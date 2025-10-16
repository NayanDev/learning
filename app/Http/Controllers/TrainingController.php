<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Idev\EasyAdmin\app\Helpers\Validation;
use Idev\EasyAdmin\app\Helpers\Constant;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;

class TrainingController extends DefaultController
{
    protected $modelClass = Training::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    // protected $arrPermissions;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Training';
        $this->generalUri = 'training';
        // $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_multilink', 'btn_approval', 'btn_delete'];

        $this->tableHeaders = [
            ['name' => 'No', 'column' => '#', 'order' => true],
            ['name' => 'Years', 'column' => 'year', 'order' => true],
            ['name' => 'End date', 'column' => 'end_date', 'order' => true],
            ['name' => 'Description', 'column' => 'description', 'order' => true],
            ['name' => 'User', 'column' => 'user', 'order' => true],
            ['name' => 'Status', 'column' => 'status', 'order' => true],
            ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
            ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];

        $this->importExcelConfig = [
            'primaryKeys' => [''],
            'headers' => []
        ];
    }

    public function indexApi()
    {
        $permission = (new Constant)->permissionByMenu($this->generalUri);
        $permission[] = 'multilink';
        $permission[] = 'approval';

        $eb = [];
        $data_columns = [];
        foreach ($this->tableHeaders as $key => $col) {
            if ($key > 0) {
                $data_columns[] = $col['column'];
            }
        }

        foreach ($this->actionButtons as $key => $ab) {
            if (in_array(str_replace("btn_", "", $ab), $permission)) {
                $eb[] = $ab;
            }
        }

        $dataQueries = $this->defaultDataQuery()->paginate(10);

        $datas['extra_buttons'] = $eb;
        $datas['data_columns'] = $data_columns;
        $datas['data_queries'] = $dataQueries;
        $datas['data_permissions'] = $permission;
        $datas['uri_key'] = $this->generalUri;

        return $datas;
    }

    public function index()
    {
        $baseUrlExcel = route($this->generalUri . '.export-excel-default');
        $baseUrlPdf = route($this->generalUri . '.export-pdf-default');

        $moreActions = [
            [
                'key' => 'import-excel-default',
                'name' => 'Import Excel',
                'html_button' => "<button id='import-excel' type='button' class='btn btn-sm btn-info radius-6' href='#' data-bs-toggle='modal' data-bs-target='#modalImportDefault' title='Import Excel' ><i class='ti ti-upload'></i></button>"
            ],
            [
                'key' => 'export-excel-default',
                'name' => 'Export Excel',
                'html_button' => "<a id='export-excel' data-base-url='" . $baseUrlExcel . "' class='btn btn-sm btn-success radius-6' target='_blank' href='" . url($this->generalUri . '-export-excel-default') . "'  title='Export Excel'><i class='ti ti-cloud-download'></i></a>"
            ],
            [
                'key' => 'export-pdf-default',
                'name' => 'Export Pdf',
                'html_button' => "<a id='export-pdf' data-base-url='" . $baseUrlPdf . "' class='btn btn-sm btn-danger radius-6' target='_blank' href='" . url($this->generalUri . '-export-pdf-default') . "' title='Export PDF'><i class='ti ti-file'></i></a>"
            ],
        ];

        $permissions =  $this->arrPermissions;
        if ($this->dynamicPermission) {
            $permissions = (new Constant())->permissionByMenu($this->generalUri);
        }
        $layout = (request('from_ajax') && request('from_ajax') == true) ? 'easyadmin::backend.idev.list_drawer_ajax' : 'easyadmin::backend.idev.list_drawer';
        if (isset($this->drawerLayout)) {
            $layout = $this->drawerLayout;
        }
        $data['permissions'] = $permissions;
        $data['more_actions'] = $moreActions;
        $data['headerLayout'] = $this->pageHeaderLayout;
        $data['table_headers'] = $this->tableHeaders;
        $data['title'] = $this->title;
        $data['uri_key'] = $this->generalUri;
        $data['uri_list_api'] = route($this->generalUri . '.listapi');
        $data['uri_create'] = route($this->generalUri . '.create');
        $data['url_store'] = route($this->generalUri . '.store');
        $data['fields'] = $this->fields();
        $data['edit_fields'] = $this->fields('edit');
        $data['actionButtonViews'] = [
            'easyadmin::backend.idev.buttons.delete',
            'easyadmin::backend.idev.buttons.edit',
            'easyadmin::backend.idev.buttons.show',
            'easyadmin::backend.idev.buttons.import_default',
            'backend.idev.buttons.multilink',
            'backend.idev.buttons.approval',
        ];
        $data['templateImportExcel'] = "#";
        $data['import_scripts'] = $this->importScripts;
        $data['import_styles'] = $this->importStyles;
        $data['filters'] = $this->filters();

        return view($layout, $data);
    }

    protected function defaultDataQuery()
    {
        $filters = [];
        $orThose = null;
        $orderBy = 'id';
        $orderState = 'DESC';
        if (request('search')) {
            $orThose = request('search');
        }
        if (request('order')) {
            $orderBy = request('order');
            $orderState = request('order_state');
        }

        $dataQueries = Training::join('users', 'users.id', '=', 'trainings.user_id')
            ->where($filters)
            ->where(function ($query) use ($orThose) {
                $query->where('trainings.year', 'LIKE', '%' . $orThose . '%');
                $query->where('trainings.description', 'LIKE', '%' . $orThose . '%');
                $query->where('users.name', 'LIKE', '%' . $orThose . '%');
                $query->where('trainings.status', 'LIKE', '%' . $orThose . '%');
            })
            ->orderBy($orderBy, $orderState)
            ->select('trainings.*', 'users.name as user');

        return $dataQueries;
    }

    protected function fields($mode = "create", $id = '-')
    {
        $edit = null;
        if ($id != '-') {
            $edit = $this->modelClass::where('id', $id)->first();
        }

        $fields = [
            [
                'type' => 'textarea',
                'label' => 'Description',
                'name' =>  'description',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('name', $id),
                'value' => (isset($edit)) ? $edit->description : '-'
            ],
            [
                'type' => 'datetime',
                'label' => 'End Date',
                'name' =>  'end_date',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('name', $id),
                'value' => (isset($edit)) ? $edit->end_date : ''
            ],
            [
                'type' => 'hidden',
                'label' => 'User Id',
                'name' =>  'user_id',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('name', $id),
                'value' => (isset($edit)) ? $edit->user_id : ''
            ],
            [
                'type' => 'hidden',
                'label' => 'Year',
                'name' =>  'year',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('name', $id),
                'value' => (isset($edit)) ? $edit->year : ''
            ],
            [
                'type' => 'hidden',
                'label' => 'Status',
                'name' =>  'status',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('name', $id),
                'value' => (isset($edit)) ? $edit->status : ''
            ],
        ];

        return $fields;
    }

    protected function rules($id = null)
    {
        $rules = [
            'description' => 'required|string',
            'end_date' => 'required',
        ];

        return $rules;
    }

    protected function store(Request $request)
    {
        $rules = $this->rules();
        $description = $request->description;
        $endDate = $request->end_date;

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messageErrors = (new Validation)->modify($validator, $rules);

            return response()->json([
                'status' => false,
                'alert' => 'danger',
                'message' => 'Required Form',
                'validation_errors' => $messageErrors,
            ], 200);
        }

        DB::beginTransaction();

        try {
            $insert = new Training();
            $insert->year = date('Y') + 1;
            $insert->status = 'open';
            $insert->end_date = $endDate;
            $insert->description = $description;
            $insert->user_id = Auth::user()->id;

            $insert->save();

            $this->afterMainInsert($insert, $request);

            DB::commit();

            return response()->json([
                'status' => true,
                'alert' => 'success',
                'message' => 'Data Was Created Successfully',
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function approve(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $training = Training::findOrFail($id);

            if ($request->status === 'approve') {
                $training->created_date = now();
            }
            if ($request->status === 'close') {
                // Input Event / Copy data from training need workshop
                $this->copyTrainingDataToEvents($id);
            }

            $training->status = $request->status;
            $training->approve_by = $request->approve_by;
            $training->notes = $request->notes ?: '-';
            $training->updated_at = now();
            $training->save();

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Status updated successfully'
            ]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Copy data dari training need workshops ke events
     * dan copy data dari need participants ke participants
     */
    private function copyTrainingDataToEvents($trainingId)
    {
        try {
            // Ambil data training need workshops berdasarkan training_id
            $trainingNeeds = DB::table('training_needs')
                ->where('training_id', $trainingId)
                ->get();
            $training = Training::findOrFail($trainingId);
            $token = Str::random(32);

            if ($trainingNeeds->isEmpty()) {
                return; // Tidak ada data training needs, skip
            }

            foreach ($trainingNeeds as $trainingNeed) {
                // Ambil workshop data dari training_need_workshops
                $workshops = DB::table('training_need_workshops')
                    ->where('training_need_id', $trainingNeed->id)
                    ->get();

                foreach ($workshops as $workshop) {
                    // Cek apakah workshop_id valid
                    $workshopExists = DB::table('workshops')
                        ->where('id', $workshop->workshop_id)
                        ->exists();

                    if (!$workshopExists) {
                        continue; // Skip jika workshop tidak ada
                    }

                    // Copy data ke tabel events
                    $eventId = DB::table('events')->insertGetId([
                        'workshop_id' => $workshop->workshop_id,
                        'year' => $training->year,
                        'letter_number' => null,
                        'organizer' => null,
                        'speaker' => null,
                        'start_date' => $workshop->start_date,
                        'end_date' => $workshop->end_date,
                        'divisi' => $workshop->divisi ?? '',
                        'instructor' => $workshop->instructor,
                        'location' => null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    // Copy participants dari need_participants ke participants
                    $needParticipants = DB::table('need_participants')
                        ->where('need_head_id', $workshop->id)
                        ->get();

                    foreach ($needParticipants as $participant) {
                        DB::table('participants')->insert([
                            'name' => $participant->name ?? '',
                            'divisi' => $participant->divisi ?? '',
                            'company' => $participant->company ?? '',
                            'nik' => $participant->nik ?? '',
                            'unit_kerja' => $participant->unit_kerja ?? '',
                            'status' => $participant->status ?? '',
                            'jk' => $participant->jk ?? '',
                            'email' => $participant->email ?? '',
                            'telp' => $participant->telp ?? '',
                            'sign_ready' => null,
                            'sign_present' => null,
                            'time_ready' => null,
                            'time_present' => null,
                            'token' => $token,
                            'token_expired' => Carbon::parse($workshop->start_date)->addHour(12),
                            'event_id' => $eventId,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        } catch (Exception $e) {
            throw new Exception('Error copying training data: ' . $e->getMessage());
        }
    }
}
