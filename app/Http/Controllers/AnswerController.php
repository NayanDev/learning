<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;

class AnswerController extends DefaultController
{
    protected $modelClass = Answer::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    // protected $arrPermissions;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Answer';
        $this->generalUri = 'answer';
        // $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
                    ['name' => 'No', 'column' => '#', 'order' => true],
                    ['name' => 'Question id', 'column' => 'question_id', 'order' => true],
                    ['name' => 'Content', 'column' => 'content', 'order' => true],
                    ['name' => 'Point', 'column' => 'point', 'order' => true], 
                    ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
                    ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [ 
            'primaryKeys' => ['question_id'],
            'headers' => [
                    ['name' => 'Question id', 'column' => 'question_id'],
                    ['name' => 'Content', 'column' => 'content'],
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
                        'label' => 'Question id',
                        'name' =>  'question_id',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('question_id', $id),
                        'value' => (isset($edit)) ? $edit->question_id : ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Content',
                        'name' =>  'content',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('content', $id),
                        'value' => (isset($edit)) ? $edit->content : ''
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
                    'question_id' => 'required|string',
                    'content' => 'required|string',
                    'point' => 'required|string',
        ];

        return $rules;
    }

}
