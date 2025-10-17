<?php

namespace App\Http\Controllers;

use App\Models\TrainingUnplanned;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;
use Illuminate\Support\Facades\Auth;

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
                    ['name' => 'Year', 'column' => 'year', 'order' => true],
                    ['name' => 'User', 'column' => 'username', 'order' => true],
                    ['name' => 'Department', 'column' => 'divisi', 'order' => true],
                    ['name' => 'Status', 'column' => 'status', 'order' => true],
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

        $fields = [
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
        if (request('training_id')) {
            $filters[] = ['training_id', '=', request('training_id')];
        }

        $dataQueries = TrainingUnplanned::join('trainings', 'trainings.id', '=', 'training_unplanned.training_id')
            // ->join('employees', 'employees.id', '=', 'training_unplanned.nik')
            ->join('users', 'users.id', '=', 'training_unplanned.user_id')
            ->where($filters)
            ->where(function ($query) use ($orThose) {
                $query->where('trainings.year', 'LIKE', '%' . $orThose . '%')
                    ->orWhere('users.name', 'LIKE', '%' . $orThose . '%');
            });

        // Cek role user
        if (Auth::user()->role->name !== 'admin') {
            $dataQueries = $dataQueries->where('training_unplanned.divisi', Auth::user()->divisi);
        }

        $dataQueries = $dataQueries
            ->orderBy($orderBy, $orderState)
            ->select(
                'training_unplanned.*',
                'trainings.year as year',
                'users.name as username',
                // 'employees.first_name as employeename'
            );

        return $dataQueries;
    }

}
