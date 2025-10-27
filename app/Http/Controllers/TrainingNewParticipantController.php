<?php

namespace App\Http\Controllers;

use App\Models\TrainingNewParticipant;
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
