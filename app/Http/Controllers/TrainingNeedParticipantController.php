<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Idev\EasyAdmin\app\Helpers\Validation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\TrainingNeedParticipant;
use Idev\EasyAdmin\app\Helpers\Constant;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;

class TrainingNeedParticipantController extends DefaultController
{
    protected $modelClass = TrainingNeedParticipant::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    // protected $arrPermissions;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Training Need Participant';
        $this->generalUri = 'training-need-participant';
        // $this->arrPermissions = [];
        $this->actionButtons = ['btn_delete'];

        $this->tableHeaders = [
                    ['name' => 'No', 'column' => '#', 'order' => true],
                    ['name' => 'Name', 'column' => 'name', 'order' => true],
                    // ['name' => 'Need head id', 'column' => 'need_head_id', 'order' => true], 
                    ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
                    ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [ 
            'primaryKeys' => [''],
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
                    'type' => 'participant',
                    'label' => 'Participant',
                    'name' => 'name',
                    'class' => 'col-md-12 my-2',
                    'key' => 'nik',
                    'ajaxUrl' => url('participant-ajax'),
                    'table_headers' => ['Name', 'Department', 'Position', 'NIK']
                    ],
                    [
                        'type' => 'onlyview',
                        'label' => 'TrainingID',
                        'name' =>  'need_head_id',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('name', $id),
                        'value' => (isset($edit)) ? $edit->need_head_id : request('header')
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

    public function index()
    {
        $baseUrlExcel = route($this->generalUri.'.export-excel-default');
        $baseUrlPdf = route($this->generalUri.'.export-pdf-default');

        $params = "";
        if(request('header')){
            $params = "?header=".request('header');
        }

        $moreActions = [
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
        $data['uri_list_api'] = route($this->generalUri . '.listapi') . $params;
        $data['uri_create'] = route($this->generalUri . '.create');
        $data['url_store'] = route($this->generalUri . '.store');
        $data['fields'] = $this->fields();
        $data['edit_fields'] = $this->fields('edit');
        $data['actionButtonViews'] = $this->actionButtonViews;
        $data['templateImportExcel'] = "#";
        $data['import_scripts'] = $this->importScripts;
        $data['import_styles'] = $this->importStyles;
        $data['filters'] = $this->filters();
        $data['drawerExtraClass'] = 'w-50';
        
        return view($layout, $data);
        
    }

    protected function store(Request $request)
    {
        try {
            $rules = $this->rules();
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

            // Decode JSON string dari input hidden
            $selectedNames = json_decode($request->name, true);
            
            if (empty($selectedNames)) {
                throw new Exception('Tidak ada peserta yang dipilih');
            }

            // Debug log
            Log::info('Selected Names:', ['names' => $selectedNames]);

            foreach ($selectedNames as $nama) {
                $insert = new TrainingNeedParticipant();
                $insert->name = $nama; // Now storing nama instead of NIK
                $insert->need_head_id = $request->need_head_id;
                $insert->save();
            }
            
            DB::commit();

            return response()->json([
                'status' => true,
                'alert' => 'success',
                'message' => 'Data berhasil disimpan',
            ], 200);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error storing training needs: ' . $e->getMessage());
            
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
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

        if(request('header')) {
            $filters[] = ['need_head_id', '=', request('header')];
        }

        $dataQueries = $this->modelClass::where($filters)
            ->where(function ($query) use ($orThose) {
                $efc = ['#', 'created_at', 'updated_at', 'id'];

                foreach ($this->tableHeaders as $key => $th) {
                    if (array_key_exists('search', $th) && $th['search'] == false) {
                        $efc[] = $th['column'];
                    }
                    if(!in_array($th['column'], $efc))
                    {
                        if($key == 0){
                            $query->where($th['column'], 'LIKE', '%' . $orThose . '%');
                        }else{
                            $query->orWhere($th['column'], 'LIKE', '%' . $orThose . '%');
                        }
                    }
                }
            })
            ->orderBy($orderBy, $orderState);

        return $dataQueries;
    }

}
