<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventQuestion;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;
use Illuminate\Support\Facades\Auth;

class EventQuestionController extends DefaultController
{
    protected $modelClass = EventQuestion::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    // protected $arrPermissions;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Event Question';
        $this->generalUri = 'event-question';
        // $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
            ['name' => 'No', 'column' => '#', 'order' => true],
            ['name' => 'Workshop id', 'column' => 'workshop_id', 'order' => true],
            ['name' => 'User id', 'column' => 'user_id', 'order' => true],
            ['name' => 'Year', 'column' => 'year', 'order' => true],
            ['name' => 'Letter number', 'column' => 'letter_number', 'order' => true],
            ['name' => 'Organizer', 'column' => 'organizer', 'order' => true],
            ['name' => 'Speaker', 'column' => 'speaker', 'order' => true],
            ['name' => 'Start date', 'column' => 'start_date', 'order' => true],
            ['name' => 'End date', 'column' => 'end_date', 'order' => true],
            ['name' => 'Divisi', 'column' => 'divisi', 'order' => true],
            ['name' => 'Token', 'column' => 'token', 'order' => true],
            ['name' => 'Token expired', 'column' => 'token_expired', 'order' => true],
            ['name' => 'Instructor', 'column' => 'instructor', 'order' => true],
            ['name' => 'Location', 'column' => 'location', 'order' => true],
            ['name' => 'Approve by', 'column' => 'approve_by', 'order' => true],
            ['name' => 'Created date', 'column' => 'created_date', 'order' => true],
            ['name' => 'Notes', 'column' => 'notes', 'order' => true],
            ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
            ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [
            'primaryKeys' => ['workshop_id'],
            'headers' => [
                ['name' => 'Workshop id', 'column' => 'workshop_id'],
                ['name' => 'User id', 'column' => 'user_id'],
                ['name' => 'Year', 'column' => 'year'],
                ['name' => 'Letter number', 'column' => 'letter_number'],
                ['name' => 'Organizer', 'column' => 'organizer'],
                ['name' => 'Speaker', 'column' => 'speaker'],
                ['name' => 'Start date', 'column' => 'start_date'],
                ['name' => 'End date', 'column' => 'end_date'],
                ['name' => 'Divisi', 'column' => 'divisi'],
                ['name' => 'Token', 'column' => 'token'],
                ['name' => 'Token expired', 'column' => 'token_expired'],
                ['name' => 'Instructor', 'column' => 'instructor'],
                ['name' => 'Location', 'column' => 'location'],
                ['name' => 'Approve by', 'column' => 'approve_by'],
                ['name' => 'Created date', 'column' => 'created_date'],
                ['name' => 'Notes', 'column' => 'notes'],
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
                'label' => 'Year',
                'name' =>  'year',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('year', $id),
                'value' => (isset($edit)) ? $edit->year : ''
            ],
            [
                'type' => 'text',
                'label' => 'Letter number',
                'name' =>  'letter_number',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('letter_number', $id),
                'value' => (isset($edit)) ? $edit->letter_number : ''
            ],
            [
                'type' => 'text',
                'label' => 'Organizer',
                'name' =>  'organizer',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('organizer', $id),
                'value' => (isset($edit)) ? $edit->organizer : ''
            ],
            [
                'type' => 'text',
                'label' => 'Speaker',
                'name' =>  'speaker',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('speaker', $id),
                'value' => (isset($edit)) ? $edit->speaker : ''
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
                'label' => 'Divisi',
                'name' =>  'divisi',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('divisi', $id),
                'value' => (isset($edit)) ? $edit->divisi : ''
            ],
            [
                'type' => 'text',
                'label' => 'Token',
                'name' =>  'token',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('token', $id),
                'value' => (isset($edit)) ? $edit->token : ''
            ],
            [
                'type' => 'text',
                'label' => 'Token expired',
                'name' =>  'token_expired',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('token_expired', $id),
                'value' => (isset($edit)) ? $edit->token_expired : ''
            ],
            [
                'type' => 'text',
                'label' => 'Instructor',
                'name' =>  'instructor',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('instructor', $id),
                'value' => (isset($edit)) ? $edit->instructor : ''
            ],
            [
                'type' => 'text',
                'label' => 'Location',
                'name' =>  'location',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('location', $id),
                'value' => (isset($edit)) ? $edit->location : ''
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
                'label' => 'Created date',
                'name' =>  'created_date',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('created_date', $id),
                'value' => (isset($edit)) ? $edit->created_date : ''
            ],
            [
                'type' => 'text',
                'label' => 'Notes',
                'name' =>  'notes',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('notes', $id),
                'value' => (isset($edit)) ? $edit->notes : ''
            ],
        ];

        return $fields;
    }


    protected function rules($id = null)
    {
        $rules = [
            'workshop_id' => 'required|string',
            'user_id' => 'required|string',
            'year' => 'required|string',
            'letter_number' => 'required|string',
            'organizer' => 'required|string',
            'speaker' => 'required|string',
            'start_date' => 'required|string',
            'end_date' => 'required|string',
            'divisi' => 'required|string',
            'token' => 'required|string',
            'token_expired' => 'required|string',
            'instructor' => 'required|string',
            'location' => 'required|string',
            'approve_by' => 'required|string',
            'created_date' => 'required|string',
            'notes' => 'required|string',
        ];

        return $rules;
    }

    public function testNewEmployee()
    {
        $token = request('token');
        if (!$token) {
            abort(404);
        }
        $data = Event::where('token', $token)
            ->first();

        // Get authenticated user
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized. Please login first.');
        }

        return view('backend.idev.test_new_employee', compact('data', 'user'));
    }
}
