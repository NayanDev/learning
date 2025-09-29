<?php

namespace App\Http\Controllers;

use App\Models\TrainingAnalyst;
use Idev\EasyAdmin\app\Helpers\Constant;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;

class TrainingAnalystController extends DefaultController
{
    protected $modelClass = TrainingAnalyst::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    // protected $arrPermissions;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Training Analyst';
        $this->generalUri = 'training-analyst';
        // $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
                    ['name' => 'No', 'column' => '#', 'order' => true],
                    ['name' => 'Position', 'column' => 'position', 'order' => true],
                    ['name' => 'Personil', 'column' => 'personil', 'order' => true],
                    ['name' => 'Qualification', 'column' => 'qualification', 'order' => true],
                    ['name' => 'General training', 'column' => 'general_training', 'order' => true],
                    ['name' => 'Technic training', 'column' => 'technic_training', 'order' => true],
                    ['name' => 'Status', 'column' => 'status', 'order' => true],
                    ['name' => 'User id', 'column' => 'user_id', 'order' => true],
                    ['name' => 'Approve by', 'column' => 'approve_by', 'order' => true], 
                    ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
                    ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [ 
            'primaryKeys' => ['position'],
            'headers' => [
                    ['name' => 'Position', 'column' => 'position'],
                    ['name' => 'Personil', 'column' => 'personil'],
                    ['name' => 'Qualification', 'column' => 'qualification'],
                    ['name' => 'General training', 'column' => 'general_training'],
                    ['name' => 'Technic training', 'column' => 'technic_training'],
                    ['name' => 'Status', 'column' => 'status'],
                    ['name' => 'User id', 'column' => 'user_id'],
                    ['name' => 'Approve by', 'column' => 'approve_by'], 
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
                'type' => 'multiinput',
                'label' => 'Qualification',
                'name' =>  'qualification',
                'class' => 'col-md-12 my-2',
                'enable_action' => true,
                'html_fields' => [
                    [
                        'type' => 'text',
                        'name' => 'qualification',
                        'label' => 'Data',
                        'placeholder' => 'Masukkan nama produk',
                        'class' => 'form-group col-md-10'
                    ],
                ],
                'required' => $this->flagRules('name', $id),
                'value' => (isset($edit)) ? $edit->name : ''
            ],
            [
                'type' => 'multiinput',
                'label' => 'General Training',
                'name' =>  'general',
                'class' => 'col-md-12 my-2',
                'enable_action' => true,
                'html_fields' => [
                    [
                        'type' => 'text',
                        'name' => 'data',
                        'label' => 'Data',
                        'placeholder' => 'Masukkan nama produk',
                        'class' => 'form-group col-md-10'
                    ],
                ],
                'required' => $this->flagRules('name', $id),
                'value' => (isset($edit)) ? $edit->name : ''
            ],
            [
                'type' => 'multiinput',
                'label' => 'Technical Training',
                'name' =>  'technical',
                'class' => 'col-md-12 my-2',
                'enable_action' => true,
                'html_fields' => [
                    [
                        'type' => 'text',
                        'name' => 'data',
                        'label' => 'Data',
                        'placeholder' => 'Masukkan nama produk',
                        'class' => 'form-group col-md-10'
                    ],
                ],
                'required' => $this->flagRules('name', $id),
                'value' => (isset($edit)) ? $edit->name : ''
            ],
        ];

        return $fields;
    }


    protected function rules($id = null)
    {
        $rules = [
                    'position' => 'required|string',
                    'personil' => 'required|string',
                    'qualification' => 'required|string',
                    'general_training' => 'required|string',
                    'technic_training' => 'required|string',
                    'status' => 'required|string',
                    'user_id' => 'required|string',
                    'approve_by' => 'required|string',
        ];

        return $rules;
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
        $layout = (request('from_ajax') && request('from_ajax') == true) ? 'easyadmin::backend.idev.list_drawer_ajax' : 'backend.idev.training_analyst';
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
        $data['actionButtonViews'] = $this->actionButtonViews;
        $data['templateImportExcel'] = "#";
        $data['import_scripts'] = $this->importScripts;
        $data['import_styles'] = $this->importStyles;
        $data['filters'] = $this->filters();

        return view($layout, $data);
    }

}
