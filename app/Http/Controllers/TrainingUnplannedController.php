<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Training;
use App\Models\TrainingUnplanned;
use App\Models\Workshop;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Idev\EasyAdmin\app\Helpers\Constant;
use Idev\EasyAdmin\app\Helpers\Validation;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TrainingUnplannedController extends DefaultController
{
    protected $modelClass = TrainingUnplanned::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    // protected $arrPermissions;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Training Unplanned';
        $this->generalUri = 'training-unplanned';
        // $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
                    ['name' => 'No', 'column' => '#', 'order' => true], 
                    ['name' => 'Training', 'column' => 'workshop', 'order' => true],
                    ['name' => 'User', 'column' => 'user', 'order' => true],
                    ['name' => 'Organizer', 'column' => 'organizer', 'order' => true],
                    ['name' => 'Speaker', 'column' => 'speaker', 'order' => true],
                    ['name' => 'Start Date', 'column' => 'start_date', 'order' => true],
                    ['name' => 'End Date', 'column' => 'end_date', 'order' => true],
                    ['name' => 'Divisi', 'column' => 'divisi', 'order' => true],
                    ['name' => 'Instructor', 'column' => 'instructor', 'order' => true],
                    ['name' => 'Location', 'column' => 'location', 'order' => true],
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
                'type' => 'text',
                'label' => 'Speaker',
                'name' =>  'speaker',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('name', $id),
                'value' => (isset($edit)) ? $edit->speaker : '-',
            ],
            [
                'type' => 'text',
                'label' => 'Organizer',
                'name' =>  'organizer',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('name', $id),
                'value' => (isset($edit)) ? $edit->organizer : '-',
            ],
            [
                'type' => 'select2',
                'label' => 'Instructor',
                'name' =>  'instructor',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('name', $id),
                'value' => (isset($edit)) ? $edit->instructor : '-',
                'options' => $instructor
            ],
            [
                'type' => 'text',
                'label' => 'Location',
                'name' =>  'location',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('name', $id),
                'value' => (isset($edit)) ? $edit->location : '-',
            ],
            [
                'type' => 'onlyview',
                'label' => 'Divisi',
                'name' =>  'divisi',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('name', $id),
                'value' => (isset($edit)) ? $edit->year : Auth::user()->divisi,
            ],
            [
                'type' => 'hidden',
                'label' => 'trainingID',
                'name' =>  'training_id',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('name', $id),
                'value' => (isset($edit)) ? $edit->location : request('training_id'),
            ],
            [
                'type' => 'hidden',
                'label' => 'userID',
                'name' =>  'user_id',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('name', $id),
                'value' => (isset($edit)) ? $edit->location : Auth::user()->id,
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

        $dataQueries = TrainingUnplanned::join('users', 'users.id', '=', 'training_unplanes.user_id')
            ->join('workshops', 'workshops.id', '=', 'training_unplanes.workshop_id')
            ->where($filters)
            ->where(function ($query) use ($orThose) {
                $query->where('training_unplanes.workshop_id', 'LIKE', '%' . $orThose . '%');
                $query->where('training_unplanes.organizer', 'LIKE', '%' . $orThose . '%');
                $query->where('training_unplanes.speaker', 'LIKE', '%' . $orThose . '%');
                $query->where('training_unplanes.start_date', 'LIKE', '%' . $orThose . '%');
                $query->where('training_unplanes.end_date', 'LIKE', '%' . $orThose . '%');
                $query->where('training_unplanes.divisi', 'LIKE', '%' . $orThose . '%');
                $query->where('training_unplanes.instructor', 'LIKE', '%' . $orThose . '%');
                $query->where('training_unplanes.location', 'LIKE', '%' . $orThose . '%');
                $query->where('users.name', 'LIKE', '%' . $orThose . '%');
                $query->where('workshops.name', 'LIKE', '%' . $orThose . '%');
            })
            ->orderBy($orderBy, $orderState)
            ->select('training_unplanes.*', 'users.name as user', 'workshops.name as workshop');

        return $dataQueries;
    }

    protected function store(Request $request)
    {
        $training = Training::find($request->training_id);
        $rules = $this->rules();
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messageErrors = (new Validation)->modify($validator, $rules);

            return response()->json([
                'status' => false,
                'alert' => 'danger',
                'message' => 'Required Form',
                'validation_errors' => $messageErrors,
            ], 200);
        }

        DB::beginTransaction();

        try {
            $insert = new TrainingUnplanned();
            $insert->training_id = $request->training_id;
            $insert->user_id = $request->user_id;
            $insert->workshop_id = $request->workshop_id;
            $insert->organizer = $request->organizer;
            $insert->speaker = $request->speaker;
            $insert->start_date = $request->start_date;
            $insert->end_date = $request->end_date;
            $insert->divisi = $request->divisi;
            $insert->instructor = $request->instructor;
            $insert->location = $request->location;
            $insert->save();

            $event = New Event();
            $event->user_id = $request->user_id;
            $event->year = $training->year;
            $event->workshop_id = $request->workshop_id;
            $event->organizer = $request->organizer;
            $event->speaker = $request->speaker;
            $event->start_date = $request->start_date;
            $event->end_date = $request->end_date;
            $event->divisi = $request->divisi;
            $event->instructor = $request->instructor;
            $event->location = $request->location;
            $event->token = Str::random(32);
            $event->token_expired = Carbon::parse($request->start_date)->addHour(12);
            $event->save();

            $this->afterMainInsert($insert, $request);

            DB::commit();

            return response()->json([
                'status' => true,
                'alert' => 'success',
                'message' => 'Data Was Created Successfully',
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

}
