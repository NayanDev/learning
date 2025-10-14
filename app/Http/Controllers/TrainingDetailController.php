<?php

namespace App\Http\Controllers;

use App\Models\Training;
use App\Models\TrainingDetail;
use App\Models\TrainingNeed;
use Idev\EasyAdmin\app\Helpers\Constant;
use Illuminate\Support\Facades\Auth;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;
use Illuminate\Support\Facades\DB;

class TrainingDetailController extends DefaultController
{
    protected $modelClass = TrainingDetail::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    // protected $arrPermissions;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Training Detail';
        $this->generalUri = 'training-detail';
        // $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
            ['name' => 'No', 'column' => '#', 'order' => true],
            ['name' => 'Department', 'column' => 'divisi', 'order' => true],
            ['name' => 'Training', 'column' => 'workshop', 'order' => true],
            ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
            ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [
            'primaryKeys' => [''],
            'headers' => []
        ];
    }


    protected function fields($mode = "create", $id = '-')
    {
        $edit = null;
        if ($id != '-') {
            $edit = $this->modelClass::where('id', $id)->first();
        }

        $fields = [];

        return $fields;
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
            ->join('users', 'users.id', '=', 'training_needs.user_id')
            ->join('training_need_workshops', 'training_need_workshops.training_need_id', '=', 'training_needs.id')
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
            ->groupBy('training_needs.id', 'trainings.year', 'users.name') // wajib group by semua kolom select selain agregat
            ->orderBy($orderBy, $orderState)
            ->select(
                'training_needs.*',
                DB::raw('COUNT(training_need_workshops.id) as workshop')
            );

        return $dataQueries;
    }

    protected function rules($id = null)
    {
        $rules = [];

        return $rules;
    }
}
