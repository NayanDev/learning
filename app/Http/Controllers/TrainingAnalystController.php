<?php

namespace App\Http\Controllers;

use App\Models\TrainingAnalyst;
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
                        'type' => 'text',
                        'label' => 'Position',
                        'name' =>  'position',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('position', $id),
                        'value' => (isset($edit)) ? $edit->position : ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Personil',
                        'name' =>  'personil',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('personil', $id),
                        'value' => (isset($edit)) ? $edit->personil : ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Qualification',
                        'name' =>  'qualification',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('qualification', $id),
                        'value' => (isset($edit)) ? $edit->qualification : ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'General training',
                        'name' =>  'general_training',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('general_training', $id),
                        'value' => (isset($edit)) ? $edit->general_training : ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Technic training',
                        'name' =>  'technic_training',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('technic_training', $id),
                        'value' => (isset($edit)) ? $edit->technic_training : ''
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
                        'label' => 'User id',
                        'name' =>  'user_id',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('user_id', $id),
                        'value' => (isset($edit)) ? $edit->user_id : ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Approve by',
                        'name' =>  'approve_by',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('approve_by', $id),
                        'value' => (isset($edit)) ? $edit->approve_by : ''
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

}
