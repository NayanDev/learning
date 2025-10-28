<?php

namespace App\Http\Controllers;

use App\Models\TrainingNewParticipant;
use Idev\EasyAdmin\app\Helpers\Constant;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;

class TrainingNewParticipantController extends DefaultController
{
    protected $modelClass = TrainingNewParticipant::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    // protected $arrPermissions;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Training New Participant';
        $this->generalUri = 'training-new-participant';
        // $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
                    ['name' => 'No', 'column' => '#', 'order' => true],
                    ['name' => 'Test employee id', 'column' => 'test_employee_id', 'order' => true],
                    ['name' => 'Name', 'column' => 'name', 'order' => true],
                    ['name' => 'Email', 'column' => 'email', 'order' => true],
                    ['name' => 'Position', 'column' => 'position', 'order' => true],
                    ['name' => 'Type Test', 'column' => 'type', 'order' => true],
                    ['name' => 'Score', 'column' => 'score', 'order' => true], 
                    ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
                    ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [ 
            'primaryKeys' => ['test_employee_id'],
            'headers' => [
                    ['name' => 'Test employee id', 'column' => 'test_employee_id'],
                    ['name' => 'Name', 'column' => 'name'],
                    ['name' => 'Email', 'column' => 'email'],
                    ['name' => 'Position', 'column' => 'position'],
                    ['name' => 'Score', 'column' => 'score'], 
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
                        'type' => 'text',
                        'label' => 'Test employee id',
                        'name' =>  'test_employee_id',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('test_employee_id', $id),
                        'value' => (isset($edit)) ? $edit->test_employee_id : ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Name',
                        'name' =>  'name',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('name', $id),
                        'value' => (isset($edit)) ? $edit->name : ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Email',
                        'name' =>  'email',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('email', $id),
                        'value' => (isset($edit)) ? $edit->email : ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Position',
                        'name' =>  'position',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('position', $id),
                        'value' => (isset($edit)) ? $edit->position : ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Score',
                        'name' =>  'score',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('score', $id),
                        'value' => (isset($edit)) ? $edit->score : ''
                    ],
        ];
        
        return $fields;
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
        if (request('test_employee_id')) {
            $filters[] = ['test_employee_id', '=', request('test_employee_id')];
        }

        $dataQueries = $this->modelClass::where($filters)
            ->where(function ($query) use ($orThose) {
                $efc = ['#', 'created_at', 'updated_at', 'id'];

                foreach ($this->tableHeaders as $key => $th) {
                    if (array_key_exists('search', $th) && $th['search'] == false) {
                        $efc[] = $th['column'];
                    }
                    if (!in_array($th['column'], $efc)) {
                        if ($key == 0) {
                            $query->where($th['column'], 'LIKE', '%' . $orThose . '%');
                        } else {
                            $query->orWhere($th['column'], 'LIKE', '%' . $orThose . '%');
                        }
                    }
                }
            })
            ->orderBy($orderBy, $orderState);

        return $dataQueries;
    }

    public function index()
    {
        $moreActions = [
            [
                'key' => 'import-excel-default',
                'name' => 'Import Excel',
                'html_button' => "<button id='import-excel' type='button' class='btn btn-sm btn-info radius-6' href='#' data-bs-toggle='modal' data-bs-target='#modalImportDefault' title='Import Excel' ><i class='ti ti-upload'></i></button>"
            ],
            [
                'key' => 'export-excel-default',
                'name' => 'Export Excel',
                'html_button' => "<a id='export-excel' class='btn btn-sm btn-success radius-6' target='_blank' href='" . url($this->generalUri . '-export-excel-default') . "'  title='Export Excel'><i class='ti ti-cloud-download'></i></a>"
            ],
            [
                'key' => 'export-pdf-default',
                'name' => 'Export Pdf',
                'html_button' => "<a id='export-pdf' class='btn btn-sm btn-danger radius-6' target='_blank' href='" . url($this->generalUri . '-export-pdf-default') . "' title='Export PDF'><i class='ti ti-file'></i></a>"
            ],
        ];

        $params = "";
        if (request('test_employee_id')) {
            $params = "?test_employee_id=" . request('test_employee_id');
        }

        $permissions = (new Constant())->permissionByMenu($this->generalUri);
        $data['permissions'] = $permissions;
        $data['more_actions'] = $moreActions;
        $data['table_headers'] = $this->tableHeaders;
        $data['title'] = $this->title;
        $data['uri_key'] = $this->generalUri;
        $data['uri_list_api'] = route($this->generalUri . '.listapi') . $params;
        $data['uri_create'] = route($this->generalUri . '.create');
        $data['url_store'] = route($this->generalUri . '.store') . "?event_id=" . request('event_id');
        $data['fields'] = $this->fields();
        $data['edit_fields'] = $this->fields();
        $data['actionButtonViews'] = [
            'easyadmin::backend.idev.buttons.delete',
            'easyadmin::backend.idev.buttons.edit',
            'easyadmin::backend.idev.buttons.show',
            'easyadmin::backend.idev.buttons.import_default',
        ];
        $data['templateImportExcel'] = "#";
        $data['filters'] = request('event_id') ? [] : $this->filters();
        $data['drawerExtraClass'] = 'w-50';

        $layout = 'easyadmin::backend.idev.list_drawer';

        if (!request('event_id')) {
            $layout = 'easyadmin::backend.idev.list_drawer';
        }


        return view($layout, $data);
    }


    protected function rules($id = null)
    {
        $rules = [
                    'test_employee_id' => 'required|string',
                    'name' => 'required|string',
                    'email' => 'required|string',
                    'position' => 'required|string',
                    'score' => 'required|string',
        ];

        return $rules;
    }

}
