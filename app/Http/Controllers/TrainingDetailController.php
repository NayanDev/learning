<?php

namespace App\Http\Controllers;

use App\Models\Training;
use App\Models\TrainingDetail;
use App\Models\TrainingNeed;
use Illuminate\Support\Facades\Auth;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;
use Illuminate\Support\Facades\DB;

class TrainingDetailController extends DefaultController
{
    protected $modelClass = TrainingDetail::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    // protected $arrPermissions;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Training Detail';
        $this->generalUri = 'training-detail';
        // $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
            ['name' => 'No', 'column' => '#', 'order' => true],
            ['name' => 'Department', 'column' => 'divisi', 'order' => true],
            ['name' => 'Training', 'column' => 'workshop', 'order' => true],
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

        $dataQueries = TrainingNeed::join('trainings', 'trainings.id', '=', 'training_needs.training_id')
            // ->join('employees', 'employees.id', '=', 'training_needs.nik')
            ->join('users', 'users.id', '=', 'training_needs.user_id')
            ->join('training_need_workshops', 'training_need_workshops.training_need_id', '=', 'training_needs.id')
            ->where($filters)
            ->where(function ($query) use ($orThose) {
                $query->where('trainings.year', 'LIKE', '%' . $orThose . '%')
                    ->orWhere('users.name', 'LIKE', '%' . $orThose . '%');
            });

        // Cek role user
        if (Auth::user()->role->name !== 'admin') {
            $dataQueries = $dataQueries->where('training_needs.divisi', Auth::user()->divisi);
        }

        $dataQueries = $dataQueries
            ->groupBy('training_needs.id', 'trainings.year', 'users.name') // wajib group by semua kolom select selain agregat
            ->orderBy($orderBy, $orderState)
            ->select(
                'training_needs.*',
                DB::raw('COUNT(training_need_workshops.id) as workshop')
            );

        return $dataQueries;
    }

    protected function rules($id = null)
    {
        $rules = [];

        return $rules;
    }
}
