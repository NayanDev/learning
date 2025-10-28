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
            ['name' => 'User id', 'column' => 'user', 'order' => true],
            ['name' => 'Question id', 'column' => 'question', 'order' => true],
            ['name' => 'Answer id', 'column' => 'answer', 'order' => true],
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

        $dataQueries = EventAnswer::join('users', 'users.id', '=', 'event_answers.user_id')
            ->join('questions', 'questions.id', '=', 'event_answers.question_id')
            ->join('answers', 'answers.id', '=', 'event_answers.answer_id')
            ->where($filters)
            ->where(function ($query) use ($orThose) {
                $query->where('users.name', 'LIKE', '%' . $orThose . '%');
                $query->where('questions.question_text', 'LIKE', '%' . $orThose . '%');
                $query->where('answers.content', 'LIKE', '%' . $orThose . '%');
            })
            ->orderBy($orderBy, $orderState)
            ->select('event_answers.*', 'users.name as user', 'questions.question_text as question', 'answers.content as answer');

        return $dataQueries;
    }
}
