<?php

namespace App\Http\Controllers;

use App\Models\ResultQuestion;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;

class ResultQuestionController extends DefaultController
{
    protected $modelClass = ResultQuestion::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    // protected $arrPermissions;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Result Question';
        $this->generalUri = 'result-question';
        // $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
            ['name' => 'No', 'column' => '#', 'order' => true],
            ['name' => 'Event id', 'column' => 'event_id', 'order' => true],
            ['name' => 'User id', 'column' => 'user', 'order' => true],
            ['name' => 'Type', 'column' => 'type', 'order' => true],
            ['name' => 'Score', 'column' => 'score', 'order' => true],
            ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
            ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [
            'primaryKeys' => ['event_id'],
            'headers' => [
                ['name' => 'Event id', 'column' => 'event_id'],
                ['name' => 'User id', 'column' => 'user_id'],
                ['name' => 'Type', 'column' => 'type'],
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
                'label' => 'Event id',
                'name' =>  'event_id',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('event_id', $id),
                'value' => (isset($edit)) ? $edit->event_id : ''
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
                'label' => 'Type',
                'name' =>  'type',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('type', $id),
                'value' => (isset($edit)) ? $edit->type : ''
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
            'event_id' => 'required|string',
            'user_id' => 'required|string',
            'type' => 'required|string',
            'score' => 'required|string',
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

        $dataQueries = ResultQuestion::join('users', 'users.id', '=', 'result_questions.user_id')
            ->where($filters)
            ->where(function ($query) use ($orThose) {
                $query->where('users.name', 'LIKE', '%' . $orThose . '%');
            })
            ->orderBy($orderBy, $orderState)
            ->select('result_questions.*', 'users.name as user');

        return $dataQueries;
    }
}
