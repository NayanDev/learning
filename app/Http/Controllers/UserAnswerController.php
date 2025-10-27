<?php

namespace App\Http\Controllers;

use App\Models\UserAnswer;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;

class UserAnswerController extends DefaultController
{
    protected $modelClass = UserAnswer::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    // protected $arrPermissions;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'User Answer';
        $this->generalUri = 'user-answer';
        // $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
                    ['name' => 'No', 'column' => '#', 'order' => true],
                    ['name' => 'Name', 'column' => 'name', 'order' => true],
                    ['name' => 'Email', 'column' => 'email', 'order' => true],
                    ['name' => 'Position', 'column' => 'position', 'order' => true],
                    ['name' => 'Test employee id', 'column' => 'test_employee_id', 'order' => true],
                    ['name' => 'Question id', 'column' => 'question_id', 'order' => true],
                    ['name' => 'Answer id', 'column' => 'answer_id', 'order' => true],
                    ['name' => 'Point', 'column' => 'point', 'order' => true], 
                    ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
                    ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [ 
            'primaryKeys' => ['name'],
            'headers' => [
                    ['name' => 'Name', 'column' => 'name'],
                    ['name' => 'Email', 'column' => 'email'],
                    ['name' => 'Position', 'column' => 'position'],
                    ['name' => 'Test employee id', 'column' => 'test_employee_id'],
                    ['name' => 'Question id', 'column' => 'question_id'],
                    ['name' => 'Answer id', 'column' => 'answer_id'],
                    ['name' => 'Point', 'column' => 'point'], 
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
                        'label' => 'Test employee id',
                        'name' =>  'test_employee_id',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('test_employee_id', $id),
                        'value' => (isset($edit)) ? $edit->test_employee_id : ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Question id',
                        'name' =>  'question_id',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('question_id', $id),
                        'value' => (isset($edit)) ? $edit->question_id : ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Answer id',
                        'name' =>  'answer_id',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('answer_id', $id),
                        'value' => (isset($edit)) ? $edit->answer_id : ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Point',
                        'name' =>  'point',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('point', $id),
                        'value' => (isset($edit)) ? $edit->point : ''
                    ],
        ];
        
        return $fields;
    }


    protected function rules($id = null)
    {
        $rules = [
                    'name' => 'required|string',
                    'email' => 'required|string',
                    'position' => 'required|string',
                    'test_employee_id' => 'required|string',
                    'question_id' => 'required|string',
                    'answer_id' => 'required|string',
                    'point' => 'required|string',
        ];

        return $rules;
    }

}
