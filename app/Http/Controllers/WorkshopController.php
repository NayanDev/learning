<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Workshop;
use Illuminate\Support\Facades\Auth;
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
                        'type' => 'text',
                        'label' => 'Department',
                        'name' =>  'department',
                        'class' => 'col-md-12 my-2',
                        'value' => (isset($edit)) ? $edit->department : Auth::user()->divisi,
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

}
