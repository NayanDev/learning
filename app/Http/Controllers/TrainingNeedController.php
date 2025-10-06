<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\TrainingNeed;
use App\Models\Workshop;
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
                    ['name' => 'Training', 'column' => 'workshop', 'order' => true], 
                    ['name' => 'Year', 'column' => 'year', 'order' => true],
                    ['name' => 'User', 'column' => 'username', 'order' => true], 
                    ['name' => 'Status', 'column' => 'status', 'order' => true], 
                    ['name' => 'Start', 'column' => 'start_date', 'order' => true], 
                    ['name' => 'End', 'column' => 'end_date', 'order' => true], 
                    ['name' => 'Instructor', 'column' => 'instructor', 'order' => true], 
                    ['name' => 'Position', 'column' => 'position', 'order' => true], 
                    ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
                    ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [ 
            'primaryKeys' => ['nik'],
            'headers' => [
                    ['name' => 'Nik', 'column' => 'nik'],
                    ['name' => 'Training id', 'column' => 'training_id'],
                    ['name' => 'Workshop id', 'column' => 'workshop_id'],
                    ['name' => 'User id', 'column' => 'user_id'],
                    ['name' => 'Status', 'column' => 'status'],
                    ['name' => 'Approve by', 'column' => 'approve_by'],
                    ['name' => 'Start date', 'column' => 'start_date'],
                    ['name' => 'End date', 'column' => 'end_date'],
                    ['name' => 'Instructur', 'column' => 'instructur'],
                    ['name' => 'Name', 'column' => 'name'],
                    ['name' => 'Position', 'column' => 'position'], 
            ]
        ];
    }


    protected function fields($mode = "create", $id = '-')
    {
        $edit = null;
        if ($id != '-') {
            $edit = $this->modelClass::where('id', $id)->first();
        }

        $instructor = [
            ['value' => 'internal', 'text' => 'Internal'],
            ['value' => 'external', 'text' => 'External'],
        ];

        $workshop = Workshop::select(['id as value', 'name as text'])->get();

        $fields = [
                    [
                        'type' => 'select2',
                        'label' => 'Workshop',
                        'name' =>  'workshop_id',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('name', $id),
                        'value' => (isset($edit)) ? $edit->workshop_id : '',
                        'options' => $workshop
                    ],
                    [
                        'type' => 'datetime',
                        'label' => 'Start Date',
                        'name' =>  'start_date',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('name', $id),
                        'value' => (isset($edit)) ? $edit->start_date : ''
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
                        'type' => 'select2',
                        'label' => 'Instructor',
                        'name' =>  'instructor',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('name', $id),
                        'value' => (isset($edit)) ? $edit->instructor : '',
                        'options' => $instructor
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Position',
                        'name' =>  'position',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('name', $id),
                        'value' => (isset($edit)) ? $edit->position : Auth::user()->divisi
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
                        'value' => (isset($edit)) ? $edit->email : Auth::user()->id
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
            [
                'key' => 'export-pdf-default',
                'name' => 'Export Pdf',
                'html_button' => "<a id='export-pdf' data-base-url='".$baseUrlPdf."' class='btn btn-md btn-danger radius-6' target='_blank' href='" . url($this->generalUri . '-export-pdf-default') . "' title='Export PDF'><i class='ti ti-file'></i> Print Data</a>"
            ],
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
            ->join('workshops', 'workshops.id', '=', 'training_needs.workshop_id')
            ->join('users', 'users.id', '=', 'training_needs.user_id')
            ->where($filters)
            ->where(function ($query) use ($orThose) {
                $query->where('trainings.year', 'LIKE', '%' . $orThose . '%')
                    ->orWhere('workshops.name', 'LIKE', '%' . $orThose . '%')
                    ->orWhere('users.name', 'LIKE', '%' . $orThose . '%')
                    ->orWhere('training_needs.status', 'LIKE', '%' . $orThose . '%')
                    ->orWhere('training_needs.start_date', 'LIKE', '%' . $orThose . '%')
                    ->orWhere('training_needs.end_date', 'LIKE', '%' . $orThose . '%')
                    ->orWhere('training_needs.instructor', 'LIKE', '%' . $orThose . '%')
                    ->orWhere('training_needs.position', 'LIKE', '%' . $orThose . '%');
            })
                ->orderBy($orderBy, $orderState)
                ->select(
                'training_needs.*',
                'trainings.year as year',
                'users.name as username',
                'workshops.name as workshop'
                // 'employees.first_name as employeename'
            );

        return $dataQueries;
    }

}
