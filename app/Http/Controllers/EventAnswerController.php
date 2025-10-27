<?php

namespace App\Http\Controllers;

use App\Models\EventAnswer;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;

class EventAnswerController extends DefaultController
{
    protected $modelClass = EventAnswer::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    // protected $arrPermissions;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Event Answer';
        $this->generalUri = 'event-answer';
        // $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
                    ['name' => 'No', 'column' => '#', 'order' => true],
                    ['name' => 'User id', 'column' => 'user_id', 'order' => true],
                    ['name' => 'Question id', 'column' => 'question_id', 'order' => true],
                    ['name' => 'Answer id', 'column' => 'answer_id', 'order' => true],
                    ['name' => 'Point', 'column' => 'point', 'order' => true], 
                    ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
                    ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [ 
            'primaryKeys' => ['user_id'],
            'headers' => [
                    ['name' => 'User id', 'column' => 'user_id'],
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
                        'label' => 'User id',
                        'name' =>  'user_id',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('user_id', $id),
                        'value' => (isset($edit)) ? $edit->user_id : ''
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
                    'user_id' => 'required|string',
                    'question_id' => 'required|string',
                    'answer_id' => 'required|string',
                    'point' => 'required|string',
        ];

        return $rules;
    }

}
