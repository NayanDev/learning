<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;

class EmployeeController extends DefaultController
{
    protected $modelClass = Employee::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    // protected $arrPermissions;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Employee';
        $this->generalUri = 'employee';
        // $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
                    ['name' => 'No', 'column' => '#', 'order' => true],
                    ['name' => 'Nik', 'column' => 'nik', 'order' => true],
                    ['name' => 'Company', 'column' => 'company', 'order' => true],
                    ['name' => 'Nama', 'column' => 'nama', 'order' => true],
                    ['name' => 'Divisi', 'column' => 'divisi', 'order' => true],
                    ['name' => 'Unit kerja', 'column' => 'unit_kerja', 'order' => true],
                    ['name' => 'Status', 'column' => 'status', 'order' => true],
                    ['name' => 'Jk', 'column' => 'jk', 'order' => true],
                    ['name' => 'Email', 'column' => 'email', 'order' => true],
                    ['name' => 'Telp', 'column' => 'telp', 'order' => true],
                    ['name' => 'Last synced', 'column' => 'last_synced', 'order' => true], 
                    ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
                    ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [ 
            'primaryKeys' => ['nik'],
            'headers' => [
                    ['name' => 'Nik', 'column' => 'nik'],
                    ['name' => 'Company', 'column' => 'company'],
                    ['name' => 'Nama', 'column' => 'nama'],
                    ['name' => 'Divisi', 'column' => 'divisi'],
                    ['name' => 'Unit kerja', 'column' => 'unit_kerja'],
                    ['name' => 'Status', 'column' => 'status'],
                    ['name' => 'Jk', 'column' => 'jk'],
                    ['name' => 'Email', 'column' => 'email'],
                    ['name' => 'Telp', 'column' => 'telp'],
                    ['name' => 'Last synced', 'column' => 'last_synced'], 
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
                        'label' => 'Nik',
                        'name' =>  'nik',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('nik', $id),
                        'value' => (isset($edit)) ? $edit->nik : ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Company',
                        'name' =>  'company',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('company', $id),
                        'value' => (isset($edit)) ? $edit->company : ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Nama',
                        'name' =>  'nama',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('nama', $id),
                        'value' => (isset($edit)) ? $edit->nama : ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Divisi',
                        'name' =>  'divisi',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('divisi', $id),
                        'value' => (isset($edit)) ? $edit->divisi : ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Unit kerja',
                        'name' =>  'unit_kerja',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('unit_kerja', $id),
                        'value' => (isset($edit)) ? $edit->unit_kerja : ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Status',
                        'name' =>  'status',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('status', $id),
                        'value' => (isset($edit)) ? $edit->status : ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Jk',
                        'name' =>  'jk',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('jk', $id),
                        'value' => (isset($edit)) ? $edit->jk : ''
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
                        'label' => 'Telp',
                        'name' =>  'telp',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('telp', $id),
                        'value' => (isset($edit)) ? $edit->telp : ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Last synced',
                        'name' =>  'last_synced',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('last_synced', $id),
                        'value' => (isset($edit)) ? $edit->last_synced : ''
                    ],
        ];
        
        return $fields;
    }


    protected function rules($id = null)
    {
        $rules = [
                    'nik' => 'required|string',
                    'company' => 'required|string',
                    'nama' => 'required|string',
                    'divisi' => 'required|string',
                    'unit_kerja' => 'required|string',
                    'status' => 'required|string',
                    'jk' => 'required|string',
                    'email' => 'required|string',
                    'telp' => 'required|string',
                    'last_synced' => 'required|string',
        ];

        return $rules;
    }

}
