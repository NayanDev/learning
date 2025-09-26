<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Workshop;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;

class WorkshopController extends DefaultController
{
    protected $modelClass = Workshop::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    // protected $arrPermissions;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Workshop';
        $this->generalUri = 'workshop';
        // $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_delete'];
        
        $this->tableHeaders = [
                    ['name' => 'No', 'column' => '#', 'order' => true], 
                    ['name' => 'Name', 'column' => 'name', 'order' => true], 
                    ['name' => 'Department', 'column' => 'department', 'order' => true], 
                    ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
                    ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [ 
            'primaryKeys' => ['name'],
            'headers' => [
                    ['name' => 'Name', 'column' => 'name'],
                    ['name' => 'Department id', 'column' => 'department_id'], 
            ]
        ];
    }


    protected function fields($mode = "create", $id = '-')
    {
        $edit = null;
        if ($id != '-') {
            $edit = $this->modelClass::where('id', $id)->first();
        }

        $department = Department::select(['id as value', 'name as text'])->get();

        $fields = [
                    [
                        'type' => 'text',
                        'label' => 'Name',
                        'name' =>  'name',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('name', $id),
                        'value' => (isset($edit)) ? $edit->name : ''
                    ],
                    [
                        'type' => 'select2',
                        'label' => 'Department',
                        'name' =>  'department_id',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('department_id', $id),
                        'value' => (isset($edit)) ? $edit->department_id : '',
                        'options' => $department,
                    ],
        ];
        
        return $fields;
    }


    protected function rules($id = null)
    {
        $rules = [
                    'name' => 'required|string',
                    'department_id' => 'required',
        ];

        return $rules;
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

        $dataQueries = Workshop::join('departments', 'departments.id', '=', 'workshops.department_id')
        ->where($filters)
        ->where(function ($query) use ($orThose) {
            $query->where('workshops.name', 'LIKE', '%' . $orThose . '%')
                ->orWhere('departments.name', 'LIKE', '%' . $orThose . '%');
        })
        ->orderBy($orderBy, $orderState)
        ->select('workshops.*', 'departments.name as department');

        return $dataQueries;
    }

}
