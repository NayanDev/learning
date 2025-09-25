<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;

class DepartmentController extends DefaultController
{
    protected $modelClass = Department::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    // protected $arrPermissions;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Department';
        $this->generalUri = 'department';
        // $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
                    ['name' => 'No', 'column' => '#', 'order' => true], 
                    ['name' => 'Name', 'column' => 'name', 'order' => true], 
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
                'type' => 'text', 
                'name' => 'name', 
                'label' => 'Name', 
                'value' => ($edit != null) ? $edit->name : '', 
                'placeholder' => 'Enter Department Name', 
                'required' => $this->flagRules('name', $id), 
                'col' => 'col-md-12',
            ],
        ];
        
        return $fields;
    }


    protected function rules($id = null)
    {
        $rules = [
            'name' => 'required|string',
        ];

        return $rules;
    }

}
