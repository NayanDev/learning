<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
use App\Models\Participant;
use Idev\EasyAdmin\app\Helpers\Constant;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;
use Illuminate\Support\Facades\Auth;

class DashboardController extends DefaultController
{
    protected $modelClass = Dashboard::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    // protected $arrPermissions;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Dashboard';
        $this->generalUri = 'dashboard';
        // $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
            ['name' => 'No', 'column' => '#', 'order' => true],
            ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
            ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [
            'primaryKeys' => [''],
            'headers' => []
        ];
    }


    protected function fields($mode = "create", $id = '-')
    {
        $edit = null;
        if ($id != '-') {
            $edit = $this->modelClass::where('id', $id)->first();
        }

        $fields = [];

        return $fields;
    }


    protected function rules($id = null)
    {
        $rules = [];

        return $rules;
    }

    public function index()
    {
        $data['title'] = $this->title;
        $data['eventsAttendance'] = $this->takeTrainingAttendance();

        $layout = (request('from_ajax') && request('from_ajax') == true) ? 'easyadmin::backend.idev.dashboard_ajax' : 'backend.idev.attendance_dashboard';

        return view($layout, $data);
    }

    public function takeTrainingAttendance()
    {
        $user = Auth::user();

        return Participant::with('event')
            ->where('nik', $user->nik)
            ->get();
    }

    public function nayantaka()
    {
        $data['title'] = $this->title;
        $data['eventsAttendance'] = $this->takeTrainingAttendance();

        $layout = (request('from_ajax') && request('from_ajax') == true) ? 'easyadmin::backend.idev.dashboard_ajax' : 'nayantaka';

        return view($layout, $data);
    }
}
