<?php

namespace App\Http\Controllers;

use App\Models\TrainingSchedule;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;

class TrainingScheduleController extends DefaultController
{
    protected $modelClass = TrainingSchedule::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    // protected $arrPermissions;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Training Schedule';
        $this->generalUri = 'training-schedule';
        // $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
                    ['name' => 'No', 'column' => '#', 'order' => true],
                    ['name' => 'Nik', 'column' => 'nik', 'order' => true],
                    ['name' => 'Training id', 'column' => 'training_id', 'order' => true],
                    ['name' => 'Workshop id', 'column' => 'workshop_id', 'order' => true],
                    ['name' => 'User id', 'column' => 'user_id', 'order' => true],
                    ['name' => 'Status', 'column' => 'status', 'order' => true],
                    ['name' => 'Approve by', 'column' => 'approve_by', 'order' => true],
                    ['name' => 'Start date', 'column' => 'start_date', 'order' => true],
                    ['name' => 'End date', 'column' => 'end_date', 'order' => true],
                    ['name' => 'Instructur', 'column' => 'instructur', 'order' => true],
                    ['name' => 'Name', 'column' => 'name', 'order' => true],
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
                        'label' => 'Training id',
                        'name' =>  'training_id',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('training_id', $id),
                        'value' => (isset($edit)) ? $edit->training_id : ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Workshop id',
                        'name' =>  'workshop_id',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('workshop_id', $id),
                        'value' => (isset($edit)) ? $edit->workshop_id : ''
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
                        'label' => 'Status',
                        'name' =>  'status',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('status', $id),
                        'value' => (isset($edit)) ? $edit->status : ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Approve by',
                        'name' =>  'approve_by',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('approve_by', $id),
                        'value' => (isset($edit)) ? $edit->approve_by : ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Start date',
                        'name' =>  'start_date',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('start_date', $id),
                        'value' => (isset($edit)) ? $edit->start_date : ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'End date',
                        'name' =>  'end_date',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('end_date', $id),
                        'value' => (isset($edit)) ? $edit->end_date : ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Instructur',
                        'name' =>  'instructur',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('instructur', $id),
                        'value' => (isset($edit)) ? $edit->instructur : ''
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
                        'label' => 'Position',
                        'name' =>  'position',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('position', $id),
                        'value' => (isset($edit)) ? $edit->position : ''
                    ],
        ];
        
        return $fields;
    }


    protected function rules($id = null)
    {
        $rules = [
                    'nik' => 'required|string',
                    'training_id' => 'required|string',
                    'workshop_id' => 'required|string',
                    'user_id' => 'required|string',
                    'status' => 'required|string',
                    'approve_by' => 'required|string',
                    'start_date' => 'required|string',
                    'end_date' => 'required|string',
                    'instructur' => 'required|string',
                    'name' => 'required|string',
                    'position' => 'required|string',
        ];

        return $rules;
    }

}
