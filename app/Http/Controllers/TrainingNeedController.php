<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\TrainingNeed;
use App\Models\TrainingNeedParticipant;
use Idev\EasyAdmin\app\Helpers\Constant;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;

class TrainingNeedController extends DefaultController
{
    protected $modelClass = TrainingNeed::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    // protected $arrPermissions;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Training Need';
        $this->generalUri = 'training-need';
        // $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
                    ['name' => 'No', 'column' => '#', 'order' => true], 
                    ['name' => 'Year', 'column' => 'year', 'order' => true],
                    ['name' => 'User', 'column' => 'username', 'order' => true], 
                    ['name' => 'Department', 'column' => 'divisi', 'order' => true], 
                    ['name' => 'Status', 'column' => 'status', 'order' => true], 
                    ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
                    ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [ 
            'primaryKeys' => ['nik'],
            'headers' => [
            ]
        ];
    }


    protected function fields($mode = "create", $id = '-')
    {
        $edit = null;
        if ($id != '-') {
            $edit = $this->modelClass::where('id', $id)->first();
        }

        $fields = [
                    [
                        'type' => 'onlyview',
                        'label' => 'TrainingID',
                        'name' =>  'training_id',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('name', $id),
                        'value' => (isset($edit)) ? $edit->training_id : request('training_id')
                    ],
                    [
                        'type' => 'onlyview',
                        'label' => 'UserID',
                        'name' =>  'user_id',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('name', $id),
                        'value' => (isset($edit)) ? $edit->user_id : Auth::user()->id
                    ],
                    [
                        'type' => 'onlyview',
                        'label' => 'Status',
                        'name' =>  'status',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('name', $id),
                        'value' => (isset($edit)) ? $edit->status : 'open'
                    ],
                    [
                        'type' => 'hidden',
                        'label' => 'Divisi',
                        'name' =>  'divisi',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('name', $id),
                        'value' => (isset($edit)) ? $edit->position : Auth::user()->divisi
                    ],
                ];
        
        return $fields;
    }


    protected function rules($id = null)
    {
        $rules = [
                    
        ];

        return $rules;
    }

    protected function getFilteredApiData()
    {
        try {
            $response = Http::acceptJson()->get('https://simco.sampharindogroup.com/api/pegawai');

            if ($response->successful()) {
                $apiEmployees = $response->json();

                if (!is_array($apiEmployees)) {
                    return ['data' => [], 'total' => 0];
                }

                $limit = (int) request()->get('length', 10);
                $start = (int) request()->get('start', 0);
                $page = ($start / $limit) + 1;

                $totalRecords = count($apiEmployees);

                $paginatedData = array_slice($apiEmployees, $start, $limit);

                return [
                    'data' => $paginatedData,
                    'total' => $totalRecords,
                    'per_page' => $limit,
                    'current_page' => $page
                ];
            }
        } catch (Exception $e) {
        Log::error("Gagal mengambil data API: " . $e->getMessage());
        }
        return ['data' => [], 'total' => 0];
    }

    public function index()
    {
        $baseUrlExcel = route($this->generalUri.'.export-excel-default');
        $baseUrlPdf = route($this->generalUri.'.export-pdf-default');

        $moreActions = [
            // [
            //     'key' => 'export-pdf-default',
            //     'name' => 'Export Pdf',
            //     'html_button' => "<a id='export-pdf' data-base-url='".$baseUrlPdf."' class='btn btn-md btn-danger radius-6' target='_blank' href='" . url('training-need-pdf') . "' title='Export PDF'><i class='ti ti-file'></i> Print Data</a>"
            // ],
        ];

        $permissions =  $this->arrPermissions;
        if ($this->dynamicPermission) {
            $permissions = (new Constant())->permissionByMenu($this->generalUri);
        }
        $layout = (request('from_ajax') && request('from_ajax') == true) ? 'easyadmin::backend.idev.list_drawer_ajax' : 'easyadmin::backend.idev.list_drawer';
        if(isset($this->drawerLayout)){
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
        $data['actionButtonViews'] = $this->actionButtonViews;
        $data['templateImportExcel'] = "#";
        $data['import_scripts'] = $this->importScripts;
        $data['import_styles'] = $this->importStyles;
        $data['filters'] = $this->filters();
        
        return view($layout, $data);
    }

    public function participantAjax()
    {
        $dataQueries = $this->getFilteredApiData();
        if (!is_array($dataQueries)) {
            $dataQueries = json_decode($dataQueries, true);
        }

        $data['header'] = ['nama', 'divisi', 'unit_kerja', 'nik'];
        $data['body'] = $dataQueries;

        return $data;
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

        $dataQueries = TrainingNeed::join('trainings', 'trainings.id', '=', 'training_needs.training_id')
            // ->join('employees', 'employees.id', '=', 'training_needs.nik')
            ->join('users', 'users.id', '=', 'training_needs.user_id')
            ->where('training_needs.divisi', Auth::user()->divisi)
            ->where($filters)
            ->where(function ($query) use ($orThose) {
                $query->where('trainings.year', 'LIKE', '%' . $orThose . '%')
                    ->orWhere('users.name', 'LIKE', '%' . $orThose . '%');
            })
                ->orderBy($orderBy, $orderState)
                ->select(
                'training_needs.*',
                'trainings.year as year',
                'users.name as username',
                // 'employees.first_name as employeename'
            );

        return $dataQueries;
    }

    public function generatePDF(Request $request)
    {
        try {
            $trainingNeeds = TrainingNeed::with([
                'training',
                'user',
                'approver',
                'workshops' => function($query) {
                    $query->with('workshop');
                },
                'participants.user'
            ])
            ->when($request->training_id, function($query) use ($request) {
                $query->where('training_id', $request->training_id);
            })
            ->get()
            ->map(function($trainingNeed) {
                // Transform workshops data
                $workshopsData = $trainingNeed->workshops->map(function($workshopItem) {
                    return [
                        'header' => [
                            'workshop_name' => $workshopItem->workshop->name,
                            'training_year' => $workshopItem->trainingNeed->training->year,
                            'instructor' => $workshopItem->instructor,
                            'start_date' => $workshopItem->start_date,
                            'end_date' => $workshopItem->end_date,
                            'position' => $workshopItem->position,
                            'created_by' => $workshopItem->trainingNeed->user->name,
                            'approved_by' => $workshopItem->trainingNeed->approver->name ?? 'Belum Disetujui',
                            'status' => $workshopItem->trainingNeed->status
                        ],
                        'participants' => $workshopItem->trainingNeed->participants
                    ];
                });
                return $workshopsData;
            })
            ->flatten(1); // Flatten the collection to get all workshops in a single level

            if ($trainingNeeds->isEmpty()) {
                return response()->json(['message' => 'Data tidak ditemukan.'], 404);
            }

            $data = [
                'trainings' => $trainingNeeds,
                'created' => TrainingNeed::with(['user', 'approver'])->findOrFail($request->training_id),
                'year' => TrainingNeed::with(['training'])->findOrFail($request->training_id)
            ];

            $pdf = PDF::loadView('pdf.rencana_training', $data)
                ->setPaper('A4', 'landscape');

            return $pdf->stream("Rencana_Training_" . date('Y-m-d') . ".pdf");

        } catch (\Exception $e) {
            Log::error("Gagal generate PDF: " . $e->getMessage());
            return response()->json(['message' => 'Gagal generate PDF: ' . $e->getMessage()], 500);
        }
    }

}
