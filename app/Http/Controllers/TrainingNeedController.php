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
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_approval', 'btn_delete'];

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
            'headers' => []
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
                'label' => 'Divisi',
                'name' =>  'divisi',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('name', $id),
                'value' => (isset($edit)) ? $edit->position : Auth::user()->divisi
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
                'label' => 'TrainingID',
                'name' =>  'training_id',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('name', $id),
                'value' => (isset($edit)) ? $edit->training_id : request('training_id')
            ],
            [
                'type' => 'hidden',
                'label' => 'UserID',
                'name' =>  'user_id',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('name', $id),
                'value' => (isset($edit)) ? $edit->user_id : Auth::user()->id
            ],
        ];

        return $fields;
    }


    protected function rules($id = null)
    {
        $rules = [];

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

                // Ambil parameter search
                $search = request()->get('search', null);

                // Jika ada search, filter data manual
                if ($search && strlen($search) > 3) {
                    $apiEmployees = array_filter($apiEmployees, function ($item) use ($search) {
                        return stripos($item['nama'], $search) !== false
                            || stripos($item['divisi'], $search) !== false
                            || stripos($item['unit_kerja'], $search) !== false
                            || stripos($item['nik'], $search) !== false;
                    });
                    // reset index array setelah filter
                    $apiEmployees = array_values($apiEmployees);
                }

                $limit = (int) request()->get('length', 10);
                $start = (int) request()->get('start', 0);
                $page = max(1, (int) (($start / $limit) + 1));

                $totalRecords = count($apiEmployees);
                $lastPage = (int) ceil($totalRecords / $limit);

                // Pagination slice dari data yang sudah difilter
                $paginatedData = array_slice($apiEmployees, $start, $limit);

                // URL dasar untuk pagination (sesuaikan URL endpointmu)
                $baseUrl = url()->current();

                // Fungsi untuk generate URL halaman
                $getPageUrl = function ($pageNum) use ($baseUrl, $limit) {
                    return $pageNum > 0 ? $baseUrl . '?' . http_build_query(['start' => ($pageNum - 1) * $limit, 'length' => $limit]) : null;
                };

                return [
                    'data' => $paginatedData,
                    'total' => $totalRecords,
                    'per_page' => $limit,
                    'current_page' => $page,
                    'last_page' => $lastPage,
                    'first_page_url' => $getPageUrl(1),
                    'last_page_url' => $getPageUrl($lastPage),
                    'next_page_url' => $page < $lastPage ? $getPageUrl($page + 1) : null,
                    'prev_page_url' => $page > 1 ? $getPageUrl($page - 1) : null,
                    'path' => $baseUrl,
                    'from' => $totalRecords > 0 ? $start + 1 : 0,
                    'to' => min($start + $limit, $totalRecords),
                    'links' => collect(range(1, $lastPage))->map(function ($pageNum) use ($page, $getPageUrl) {
                        return [
                            'url' => $getPageUrl($pageNum),
                            'label' => (string) $pageNum,
                            'active' => $pageNum === $page,
                        ];
                    })->toArray(),
                ];
            }
        } catch (Exception $e) {
            Log::error("Gagal mengambil data API: " . $e->getMessage());
        }
        return ['data' => [], 'total' => 0];
    }

    protected function indexApi()
    {
        $permission = (new Constant)->permissionByMenu($this->generalUri);
        $permission[] = 'approval';

        $eb = [];
        $dataColumns = [];
        $dataColFormat = [];
        foreach ($this->tableHeaders as $key => $col) {
            if ($key > 0) {
                $dataColumns[] = $col['column'];
                if (array_key_exists("formatting", $col)) {
                    $dataColFormat[$col['column']] = $col['formatting'];
                }
            }
        }

        foreach ($this->actionButtons as $key => $ab) {
            if (in_array(str_replace("btn_", "", $ab), $permission)) {
                $eb[] = $ab;
            }
        }

        $dataQueries = $this->defaultDataQuery()->paginate(10);

        $datas['extra_buttons'] = $eb;
        $datas['data_columns'] = $dataColumns;
        $datas['data_col_formatting'] = $dataColFormat;
        $datas['data_queries'] = $dataQueries;
        $datas['data_permissions'] = $permission;
        $datas['uri_key'] = $this->generalUri;

        return $datas;
    }

    public function index()
    {
        $baseUrlExcel = route($this->generalUri . '.export-excel-default');
        $baseUrlPdf = route($this->generalUri . '.export-pdf-default');

        $params = "";
        if (request('training_id')) {
            $params = "?training_id=" . request('training_id');
        }

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
        if (isset($this->drawerLayout)) {
            $layout = $this->drawerLayout;
        }
        $data['permissions'] = $permissions;
        $data['more_actions'] = $moreActions;
        $data['headerLayout'] = $this->pageHeaderLayout;
        $data['table_headers'] = $this->tableHeaders;
        $data['title'] = $this->title;
        $data['uri_key'] = $this->generalUri;
        $data['uri_list_api'] = route($this->generalUri . '.listapi') . $params;
        $data['uri_create'] = route($this->generalUri . '.create');
        $data['url_store'] = route($this->generalUri . '.store');
        $data['fields'] = $this->fields();
        $data['edit_fields'] = $this->fields('edit');
        $data['actionButtonViews'] = [
            'easyadmin::backend.idev.buttons.delete',
            'easyadmin::backend.idev.buttons.edit',
            'easyadmin::backend.idev.buttons.show',
            'backend.idev.buttons.approval',
        ];
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
        if (request('training_id')) {
            $filters[] = ['training_id', '=', request('training_id')];
        }

        $dataQueries = TrainingNeed::join('trainings', 'trainings.id', '=', 'training_needs.training_id')
            // ->join('employees', 'employees.id', '=', 'training_needs.nik')
            ->join('users', 'users.id', '=', 'training_needs.user_id')
            ->where($filters)
            ->where(function ($query) use ($orThose) {
                $query->where('trainings.year', 'LIKE', '%' . $orThose . '%')
                    ->orWhere('users.name', 'LIKE', '%' . $orThose . '%');
            });

        // Cek role user
        if (Auth::user()->role->name !== 'admin') {
            $dataQueries = $dataQueries->where('training_needs.divisi', Auth::user()->divisi);
        }

        $dataQueries = $dataQueries
            ->orderBy($orderBy, $orderState)
            ->select(
                'training_needs.*',
                'trainings.year as year',
                'users.name as username',
                // 'employees.first_name as employeename'
            );

        return $dataQueries;
    }

    public function approve(Request $request, $id)
    {
        $training = TrainingNeed::findOrFail($id);

        if ($request->status === 'submit') {
            $training->created_date = now();
        }
        $training->status = $request->status;
        $training->approve_by = $request->approve_by;
        $training->notes = $request->notes ?: '-';
        $training->updated_at = now();
        $training->save();

        return response()->json(['message' => 'Status updated']);
    }

    public function generatePDF(Request $request)
    {
        try {
            $trainingNeeds = TrainingNeed::with([
                'training',
                'user',
                'approver',
                'workshops' => function ($query) {
                    $query->with(['workshop', 'participants.user']);
                },
                'participants.user'
            ])
                ->when($request->training_id, function ($query) use ($request) {
                    $query->where('id', $request->training_id);
                })
                ->get()
                ->map(function ($trainingNeed) {
                    // Transform workshops data
                    $workshopsData = $trainingNeed->workshops->map(function ($workshopItem) {
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
                            'participants' => $workshopItem->participants
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
            // return dd($data);

            $pdf = PDF::loadView('pdf.rencana_training', $data)
                ->setPaper('A4', 'landscape');

            return $pdf->stream("Rencana_Training_" . date('Y-m-d') . ".pdf");
        } catch (\Exception $e) {
            Log::error("Gagal generate PDF: " . $e->getMessage());
            return response()->json(['message' => 'Gagal generate PDF: ' . $e->getMessage()], 500);
        }
    }
}
