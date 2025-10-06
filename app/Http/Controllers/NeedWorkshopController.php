<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Workshop;
use App\Models\NeedWorkshop;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;

class NeedWorkshopController extends DefaultController
{
    protected $modelClass = NeedWorkshop::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    // protected $arrPermissions;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Need Workshop';
        $this->generalUri = 'need-workshop';
        // $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
                    ['name' => 'No', 'column' => '#', 'order' => true], 
                    ['name' => 'Training', 'column' => 'workshop', 'order' => true], 
                    ['name' => 'Start Date', 'column' => 'start_date', 'order' => true], 
                    ['name' => 'End Date', 'column' => 'end_date', 'order' => true], 
                    ['name' => 'Instructor', 'column' => 'instructor', 'order' => true], 
                    ['name' => 'Position', 'column' => 'position', 'order' => true], 
                    ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
                    ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [ 
            'primaryKeys' => [''],
            'headers' => [ 
            ]
        ];
    }


    protected function fields($mode = "create", $id = '-')
    {
        $edit = null;
        if ($id != '-') {
            $edit = $this->modelClass::where('id', $id)->first();
        }

        $instructor = [
            ['value' => 'internal', 'text' => 'Internal'],
            ['value' => 'external', 'text' => 'External'],
        ];

        $workshop = Workshop::select(['id as value', 'name as text'])->get();

        $fields = [
                    [
                        'type' => 'select2',
                        'label' => 'Workshop',
                        'name' =>  'workshop_id',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('name', $id),
                        'value' => (isset($edit)) ? $edit->workshop_id : '',
                        'options' => $workshop
                    ],
                    [
                        'type' => 'datetime',
                        'label' => 'Start Date',
                        'name' =>  'start_date',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('name', $id),
                        'value' => (isset($edit)) ? $edit->start_date : ''
                    ],
                    [
                        'type' => 'datetime',
                        'label' => 'End Date',
                        'name' =>  'end_date',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('name', $id),
                        'value' => (isset($edit)) ? $edit->end_date : ''
                    ],
                    [
                        'type' => 'select2',
                        'label' => 'Instructor',
                        'name' =>  'instructor',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('name', $id),
                        'value' => (isset($edit)) ? $edit->instructor : '',
                        'options' => $instructor
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Position',
                        'name' =>  'position',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('name', $id),
                        'value' => (isset($edit)) ? $edit->position : Auth::user()->divisi
                    ],
                    [
                        'type' => 'hidden',
                        'label' => 'TrainingID',
                        'name' =>  'training_need_id',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('name', $id),
                        'value' => (isset($edit)) ? $edit->training_need_id : request('header')
                    ],
        ];
        
        return $fields;
    }


    protected function rules($id = null)
    {
        $rules = [
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

        $dataQueries = NeedWorkshop::join('training_needs', 'training_needs.id', '=', 'training_need_workshops.training_need_id')
            // ->join('employees', 'employees.id', '=', 'training_needs.nik')
            ->join('workshops', 'workshops.id', '=', 'training_need_workshops.workshop_id')
            ->where($filters)
            ->where(function ($query) use ($orThose) {
                $query->where('workshops.name', 'LIKE', '%' . $orThose . '%');
            })
                ->orderBy($orderBy, $orderState)
                ->select(
                'training_need_workshops.*',
                'workshops.name as workshop',
                // 'users.name as username',
                // 'employees.first_name as employeename'
            );

        return $dataQueries;
    }

}
