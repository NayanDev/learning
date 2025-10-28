<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\NeedWorkshop;
use App\Models\Training;
use App\Models\TrainingNeed;
use App\Models\Workshop;
use Carbon\Carbon;
use Idev\EasyAdmin\app\Helpers\Constant;
use Illuminate\Support\Facades\Log;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;

class TrainingScheduleController extends DefaultController
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
        $this->title = 'Training Schedule';
        $this->generalUri = 'training-schedule';
        // $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_show'];

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
            'primaryKeys' => ['nik'],
            'headers' => [
                ['name' => 'Nik', 'column' => 'nik'],
                ['name' => 'Training id', 'column' => 'training_id'],
                ['name' => 'Workshop id', 'column' => 'workshop_id'],
                ['name' => 'User id', 'column' => 'user_id'],
                ['name' => 'Status', 'column' => 'status'],
                ['name' => 'Approve by', 'column' => 'approve_by'],
                ['name' => 'Start date', 'column' => 'start_date'],
                ['name' => 'End date', 'column' => 'end_date'],
                ['name' => 'Instructur', 'column' => 'instructur'],
                ['name' => 'Name', 'column' => 'name'],
                ['name' => 'Position', 'column' => 'position'],
            ]
        ];
    }

    public function index()
    {
        $baseUrlExcel = route($this->generalUri . '.export-excel-default');
        $baseUrlPdf = route($this->generalUri . '.export-pdf-default');

        $params = "";
        $pdfParams = "";
        if (request('training_id')) {
            $params = "?training_id=" . request('training_id');
        }
        if (request('year')) {
            $pdfParams = "?year=" . request('year');
        }

        $moreActions = [
            [
                'key' => 'import-excel-default',
                'name' => 'Import Excel',
                'html_button' => "<button id='import-excel' type='button' class='btn btn-sm btn-info radius-6' href='#' data-bs-toggle='modal' data-bs-target='#modalImportDefault' title='Import Excel' ><i class='ti ti-upload'></i></button>"
            ],
            [
                'key' => 'export-excel-default',
                'name' => 'Export Excel',
                'html_button' => "<a id='export-excel' data-base-url='" . $baseUrlExcel . "' class='btn btn-sm btn-success radius-6' target='_blank' href='" . url($this->generalUri . '-export-excel-default') . $params . "'  title='Export Excel'><i class='ti ti-cloud-download'></i></a>"
            ],
            [
                'key' => 'export-pdf-default',
                'name' => 'Export Pdf',
                'html_button' => "<a id='export-pdf' data-base-url='" . $baseUrlPdf . "' class='btn btn-sm btn-danger radius-6' target='_blank' href='" . url('training-schedule-pdf') . $pdfParams . "' title='Export PDF'><i class='ti ti-file'></i></a>"
            ],
        ];

        $permissions =  $this->arrPermissions;
        if ($this->dynamicPermission) {
            $permissions = (new Constant())->permissionByMenu($this->generalUri);
        }
        $layout = (request('from_ajax') && request('from_ajax') == true) ? 'easyadmin::backend.idev.list_drawer_ajax' : 'easyadmin::backend.idev.list_drawer';
        if (isset($this->drawerLayout)) {
            $layout = $this->drawerLayout;
        }
        $data['permissions'] = $permissions;
        $data['more_actions'] = $moreActions;
        $data['headerLayout'] = $this->pageHeaderLayout;
        $data['table_headers'] = $this->tableHeaders;
        $data['title'] = $this->title;
        $data['uri_key'] = $this->generalUri;
        $data['uri_list_api'] = route($this->generalUri . '.listapi') . $pdfParams;
        $data['uri_create'] = route($this->generalUri . '.create');
        $data['url_store'] = route($this->generalUri . '.store');
        $data['fields'] = $this->fields();
        $data['edit_fields'] = $this->fields('edit');
        $data['actionButtonViews'] = $this->actionButtonViews;
        $data['templateImportExcel'] = "#";
        $data['import_scripts'] = $this->importScripts;
        $data['import_styles'] = $this->importStyles;
        $data['filters'] = $this->filters();

        return view($layout, $data);
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
                'value' => (isset($edit)) ? $edit->position : '',
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

    protected function filters()
    {
        $filters = [];

        return $filters;
    }


    protected function rules($id = null)
    {
        $rules = [
            'nik' => 'required|string',
            'training_id' => 'required|string',
            'workshop_id' => 'required|string',
            'user_id' => 'required|string',
            'status' => 'required|string',
            'approve_by' => 'required|string',
            'start_date' => 'required|string',
            'end_date' => 'required|string',
            'instructur' => 'required|string',
            'name' => 'required|string',
            'position' => 'required|string',
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
        if (request('year')) {
            $filters[] = ['trainings.year', '=', request('year')];
        }

        $dataQueries = NeedWorkshop::join('training_needs', 'training_needs.id', '=', 'training_need_workshops.training_need_id')
            ->join('workshops', 'workshops.id', '=', 'training_need_workshops.workshop_id')
            ->join('trainings', 'trainings.id', '=', 'training_needs.training_id')
            // ->where('trainings.year', request('year'))
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

    public function generatePDF(Request $request)
    {
        try {
            // Get all training need workshops with relationships
            $workshopsData = NeedWorkshop::with([
                'workshop',
                'trainingNeed.training',
                'trainingNeed.user',
                'participants'
            ])
                ->when($request->training_id, function ($query) use ($request) {
                    $query->whereHas('trainingNeed', function ($subQuery) use ($request) {
                        $subQuery->where('id', $request->training_id);
                    });
                })
                ->when($request->year, function ($query) use ($request) {
                    $query->whereHas('trainingNeed.training', function ($subQuery) use ($request) {
                        $subQuery->where('year', $request->year);
                    });
                })
                ->get();

            if ($workshopsData->isEmpty()) {
                $trainings = [];
            } else {
                // Group workshops by division
                $trainingsByDivision = $workshopsData->groupBy('divisi');

                // Transform data according to jadwal_training.blade.php structure
                $trainings = [];
                foreach ($trainingsByDivision as $divisi => $workshops) {
                    $workshopData = [];

                    foreach ($workshops as $workshop) {
                        // Count participants
                        $participantCount = $workshop->participants->count();
                        if ($participantCount > 1) {
                            $participantText = $participantCount . ' Personil';
                        } else if ($participantCount === 1) {
                            $participantText = ucwords(strtolower($workshop->participants[0]->name));
                        } else {
                            $participantText = ucwords(strtolower($divisi)) . ' (TBC)';
                        }

                        // Determine which weeks/months to highlight based on start_date
                        $schedule = $this->generateScheduleArray($workshop->start_date, $workshop->end_date);

                        $workshopData[$workshop->workshop->name] = [
                            'personil' => $participantText,
                            'schedule' => $schedule
                        ];
                    }

                    $trainings[] = [
                        'divisi' => $divisi ?: 'Divisi Tidak Ditentukan',
                        'training' => [
                            'workshop' => $workshopData
                        ]
                    ];
                }
            }

            $data = [
                'trainings' => $trainings,
                'year' => $request->year ?? date('Y'),
                'created' => Training::with(['user', 'approver'])
                    ->where('year', $request->year)
                    ->firstOrFail(),

            ];

            $pdf = PDF::loadView('pdf.jadwal_training', $data)
                ->setPaper('A4', 'landscape');

            return $pdf->stream("Jadwal_Training_" . ($request->year ?? date('Y')) . ".pdf");
        } catch (\Exception $e) {
            Log::error("Gagal generate PDF: " . $e->getMessage());
            return response()->json(['message' => 'Gagal generate PDF: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Generate schedule array for highlighting weeks based on start and end dates
     */
    private function generateScheduleArray($startDate, $endDate)
    {
        $schedule = [
            'jan' => [],
            'feb' => [],
            'mar' => [],
            'apr' => [],
            'may' => [],
            'jun' => [],
            'jul' => [],
            'aug' => [],
            'sep' => [],
            'oct' => [],
            'nov' => [],
            'dec' => []
        ];

        if (!$startDate || !$endDate) {
            return $schedule;
        }

        $start = \Carbon\Carbon::parse($startDate);
        $end = \Carbon\Carbon::parse($endDate);

        // Get all weeks between start and end dates
        $current = $start->copy();
        while ($current->lte($end)) {
            $monthKey = strtolower($current->format('M'));
            $weekOfMonth = ceil($current->day / 7);

            // Ensure week is between 1-4
            $weekOfMonth = min(4, max(1, $weekOfMonth));

            // Map month abbreviations
            $monthMap = [
                'jan' => 'jan',
                'feb' => 'feb',
                'mar' => 'mar',
                'apr' => 'apr',
                'may' => 'may',
                'jun' => 'jun',
                'jul' => 'jul',
                'aug' => 'aug',
                'sep' => 'sep',
                'oct' => 'oct',
                'nov' => 'nov',
                'dec' => 'dec'
            ];

            if (isset($monthMap[$monthKey]) && !in_array($weekOfMonth, $schedule[$monthMap[$monthKey]])) {
                $schedule[$monthMap[$monthKey]][] = $weekOfMonth;
            }

            $current->addWeek();
        }

        return $schedule;
    }
}
