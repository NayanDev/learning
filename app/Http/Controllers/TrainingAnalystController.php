<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\AnalystHeader;
use App\Models\AnalystBody;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Idev\EasyAdmin\app\Helpers\Constant;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;

class TrainingAnalystController extends DefaultController
{
    protected $modelClass = AnalystHeader::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    // protected $arrPermissions;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Training Analyst';
        $this->generalUri = 'training-analyst';
        // $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_approval', 'btn_delete'];

        $this->tableHeaders = [
            ['name' => 'No', 'column' => '#', 'order' => false],
            ['name' => 'qualification', 'column' => 'qualification', 'order' => true],
            ['name' => 'general', 'column' => 'general', 'order' => true],
            ['name' => 'technic', 'column' => 'technic', 'order' => true],
            ['name' => 'user', 'column' => 'username', 'order' => true],
            ['name' => 'departmen', 'column' => 'divisi', 'order' => true],
            ['name' => 'status', 'column' => 'status', 'order' => true],
            ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
            ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [
            'primaryKeys' => ['position'],
            'headers' => [
                ['name' => 'Position', 'column' => 'position'],
                ['name' => 'Personil', 'column' => 'personil'],
                ['name' => 'Qualification', 'column' => 'qualification'],
                ['name' => 'General training', 'column' => 'general_training'],
                ['name' => 'Technic training', 'column' => 'technic_training'],
                ['name' => 'Status', 'column' => 'status'],
                ['name' => 'User id', 'column' => 'user_id'],
                ['name' => 'Approve by', 'column' => 'approve_by'],
            ]
        ];
    }

    protected function fields($mode = "create", $id = '-')
    {
        $edit = null;
        if ($id != '-') {
            $edit = $this->modelClass::where('id', $id)->first();
        }

        $trainingId = request()->query('training_id');

        $fields = [
            [
                'type' => 'multiinput',
                'label' => 'Qualification',
                'name' =>  'qualification',
                'class' => 'col-md-12 my-2',
                'enable_action' => true,
                'html_fields' => [
                    [
                        'type' => 'onlyview',
                        'name' => 'qualification',
                        'label' => 'Data',
                        'value' => 'SMA',
                        'placeholder' => 'Input name qualification',
                        'class' => 'form-group col-md-10'
                    ],
                    [
                        'type' => 'onlyview',
                        'name' => 'qualification',
                        'label' => 'Data',
                        'value' => 'Bachelor',
                        'placeholder' => 'Input name qualification',
                        'class' => 'form-group col-md-10'
                    ],
                    [
                        'type' => 'onlyview',
                        'name' => 'qualification',
                        'label' => 'Data',
                        'value' => 'Sertifikasi',
                        'placeholder' => 'Input name qualification',
                        'class' => 'form-group col-md-10'
                    ],
                    [
                        'type' => 'onlyview',
                        'name' => 'qualification',
                        'label' => 'Data',
                        'value' => 'Magister',
                        'placeholder' => 'Input name qualification',
                        'class' => 'form-group col-md-10'
                    ],
                    [
                        'type' => 'onlyview',
                        'name' => 'qualification',
                        'label' => 'Data',
                        'value' => 'Doctoral',
                        'placeholder' => 'Input name qualification',
                        'class' => 'form-group col-md-10'
                    ],
                    [
                        'type' => 'onlyview',
                        'name' => 'qualification',
                        'label' => 'Data',
                        'value' => 'Professor',
                        'placeholder' => 'Input name qualification',
                        'class' => 'form-group col-md-10'
                    ],
                ],
                'required' => $this->flagRules('qualification', $id),
                'value' => (isset($edit)) ? $edit->qualification : ''
            ],
            [
                'type' => 'multiinput',
                'label' => 'General Training',
                'name' =>  'general',
                'class' => 'col-md-12 my-2',
                'enable_action' => true,
                'html_fields' => [
                    [
                        'type' => 'text',
                        'name' => 'general',
                        'label' => 'Data',
                        'placeholder' => 'Input name general training',
                        'class' => 'form-group col-md-10',
                    ],
                ],
                'required' => $this->flagRules('general', $id),
                'value' => (isset($edit)) ? $edit->general : ''
            ],
            [
                'type' => 'multiinput',
                'label' => 'Technical Training',
                'name' =>  'technical',
                'class' => 'col-md-12 my-2',
                'enable_action' => true,
                'html_fields' => [
                    [
                        'type' => 'text',
                        'name' => 'technical',
                        'label' => 'Data',
                        'placeholder' => 'input name technical training',
                        'class' => 'form-group col-md-10'
                    ],
                ],
                'required' => $this->flagRules('technical', $id),
                'value' => (isset($edit)) ? $edit->technical : ''
            ],
            [
                'type' => 'hidden',
                'name' => 'training_id',
                'label' => 'Training ID',
                'value' => $trainingId,
            ],
            [
                'type' => 'hidden',
                'label' => 'Department',
                'name' =>  'divisi',
                'class' => 'col-md-12 my-2',
                'value' => (isset($edit)) ? $edit->divisi : Auth::user()->divisi,
            ],
        ];

        return $fields;
    }

    protected function rules($id = null)
    {
        $rules = [
            'position' => 'required|string',
            'personil' => 'required|string',
            'qualification' => 'required|string',
            'general_training' => 'required|string',
            'technic_training' => 'required|string',
            'status' => 'required|string',
            'user_id' => 'required|string',
            'approve_by' => 'required|string',
        ];

        return $rules;
    }

    public function indexApi()
    {
        $permission = (new Constant)->permissionByMenu($this->generalUri);
        $permission[] = 'approval';

        $eb = [];
        $data_columns = [];
        foreach ($this->tableHeaders as $key => $col) {
            if ($key > 0) {
                $data_columns[] = $col['column'];
            }
        }

        foreach ($this->actionButtons as $key => $ab) {
            if (in_array(str_replace("btn_", "", $ab), $permission)) {
                $eb[] = $ab;
            }
        }

        $dataQueries = $this->defaultDataQuery()->paginate(10);

        $datas['extra_buttons'] = $eb;
        $datas['data_columns'] = $data_columns;
        $datas['data_queries'] = $dataQueries;
        $datas['data_permissions'] = $permission;
        $datas['uri_key'] = $this->generalUri;

        return $datas;
    }

    public function index()
    {
        $baseUrlExcel = route($this->generalUri . '.export-excel-default');
        $baseUrlPdf = route($this->generalUri . '.export-pdf-default');

        $params = "";
        if (request('training_id')) {
            $params = "?training_id=" . request('training_id');
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
                'html_button' => "<a id='export-excel' data-base-url='" . $baseUrlExcel . "' class='btn btn-sm btn-success radius-6' target='_blank' href='" . url($this->generalUri . '-export-excel-default') . "'  title='Export Excel'><i class='ti ti-cloud-download'></i></a>"
            ],
            [
                'key' => 'export-pdf-default',
                'name' => 'Export Pdf',
                'html_button' => "<a id='export-pdf' data-base-url='" . $baseUrlPdf . "' class='btn btn-sm btn-danger radius-6' target='_blank' href='" . url($this->generalUri . '-export-pdf-default') . "' title='Export PDF'><i class='ti ti-file'></i></a>"
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
        $data['uri_list_api'] = route($this->generalUri . '.listapi') . $params;
        $data['uri_create'] = route($this->generalUri . '.create');
        $data['url_store'] = route($this->generalUri . '.store');
        $data['fields'] = $this->fields();
        $data['edit_fields'] = $this->fields('edit');
        $data['actionButtonViews'] = [
            'easyadmin::backend.idev.buttons.delete',
            'easyadmin::backend.idev.buttons.edit',
            'backend.idev.buttons.approval',
        ];
        $data['templateImportExcel'] = "#";
        $data['import_scripts'] = $this->importScripts;
        $data['import_styles'] = $this->importStyles;
        $data['filters'] = $this->filters();

        return view($layout, $data);
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

        $dataQueries = AnalystHeader::join('users', 'users.id', '=', 'analyst_headers.user_id')
            ->where($filters)
            ->where(function ($query) use ($orThose) {
                $query->where('analyst_headers.qualification', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('analyst_headers.general', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('analyst_headers.technic', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('analyst_headers.status', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('analyst_headers.divisi', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('users.name', 'LIKE', '%' . $orThose . '%');
            });

        // Cek role user
        if (Auth::user()->role->name !== 'admin') {
            $dataQueries = $dataQueries->where('analyst_headers.divisi', Auth::user()->divisi);
        }

        $dataQueries = $dataQueries
            ->select('analyst_headers.*', 'users.name as username')
            ->orderBy($orderBy, $orderState);

        return $dataQueries;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'qualification'   => 'required|array',
            'qualification.*' => 'required|string', // Sesuaikan tipe data jika perlu
            'general'         => 'required|array',
            'general.*'       => 'required|string',
            'technical'       => 'required|array',
            'technical.*'     => 'required|string',
        ]);

        if ($validator->fails()) {
            // Mengembalikan response JSON jika ini adalah API request dari EasyAdmin
            return response()->json([
                'status' => false,
                'alert' => 'danger',
                'message' => 'Required Form',
                'validation_errors' => $validator->errors(),
            ], 422);
        }

        try {
            $qualificationData = $request->qualification;
            $generalData = $request->general;
            $technicalData = $request->technical;

            AnalystHeader::create([
                'training_id' => $request->input('training_id'),
                'qualification' => json_encode($qualificationData),
                'general'   => json_encode($generalData),
                'technic'   => json_encode($technicalData),
                'user_id'   => Auth::user()->id,
                'divisi'   => $request->input('divisi'),
            ]);

            // Mengembalikan response JSON yang sesuai untuk EasyAdmin
            return response()->json([
                'status' => true,
                'alert' => 'success',
                'message' => 'Data berhasil disimpan!',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function saveAll(Request $request)
    {
        try {
            DB::beginTransaction();
            $headerId = intval($request->analyst_head_id);

            // Dapatkan semua ID yang ada untuk user ini
            $existingIds = AnalystBody::where('analyst_head_id', $headerId)
                ->pluck('id')
                ->toArray();

            $processedIds = [];

            // Simpan atau update data
            foreach ($request->training_data as $index => $data) {
                $id = isset($existingIds[$index]) ? $existingIds[$index] : null;

                $training = AnalystBody::updateOrCreate(
                    [
                        'id' => $id,
                        'analyst_head_id' => $headerId
                    ],
                    [
                        'position' => $data['position'],
                        'personil' => $data['personil'],
                        'qualification' => json_encode($data['qualification']),
                        'general' => json_encode($data['general']),
                        'technic' => json_encode($data['technic'])
                    ]
                );

                $processedIds[] = $training->id;
            }

            // Hapus data yang tidak ada lagi di form
            AnalystBody::where('analyst_head_id', $headerId)
                ->whereNotIn('id', $processedIds)
                ->delete();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil disimpan!'
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function generatePDF(Request $request)
    {
        if (!$request->has('header')) {
            abort(404); // atau redirect()->route('home');
        }

        // Cek validitas ID-nya
        $header = AnalystHeader::find($request->input('header'));
        if (!$header) {
            abort(404);
        }

        $analystHeader = AnalystHeader::where('id', $request->header)->get();
        $analystBody = AnalystBody::where('analyst_head_id', $request->header)->get();

        $data = [
            'analystHeader' => $analystHeader,
            'analystBody' => $analystBody,
            'year' => AnalystHeader::with(['training'])->findOrFail($request->header),
            'created' => AnalystHeader::with(['user', 'approver'])->findOrFail($request->header),
        ];

        $pdf = PDF::loadView('pdf.analisa_training', $data)
            ->setPaper('A4', 'portrait');

        return $pdf->stream($this->title . '.pdf');
    }

    public function trainingForm(Request $request)
    {
        if (!$request->has('header')) {
            abort(404); // atau redirect()->route('home');
        }

        // Cek validitas ID-nya
        $header = AnalystHeader::find($request->input('header'));
        if (!$header) {
            abort(404);
        }

        $permissions =  $this->arrPermissions;
        if ($this->dynamicPermission) {
            $permissions = (new Constant())->permissionByMenu($this->generalUri);
        }
        $layout = (request('from_ajax') && request('from_ajax') == true) ? 'easyadmin::backend.idev.list_drawer_ajax' : 'backend.idev.training_analyst';
        if (isset($this->drawerLayout)) {
            $layout = $this->drawerLayout;
        }

        $analystHeader = AnalystHeader::where('id', $request->header)->get();
        $analystBody = AnalystBody::where('analyst_head_id', $request->header)->get();

        $data['title'] = $this->title;
        $data['uri_key'] = $this->generalUri;
        $data['permissions'] = $permissions;
        $data['url_store'] = route($this->generalUri . '.store');
        $data['fields'] = $this->fields();
        $data['actionButtonViews'] = $this->actionButtonViews;
        $data['edit_fields'] = $this->fields('edit');
        $data['templateImportExcel'] = "#";

        $data['training_data'] = $analystHeader;
        $data['training_body'] = $analystBody;

        return view($layout, $data);
    }

    public function approve(Request $request, $id)
    {
        $training = AnalystHeader::findOrFail($id);

        if ($request->status === 'submit') {
            $training->created_date = now();
        }
        $training->status = $request->status;
        $training->approve_by = $request->approve_by;
        $training->notes = $request->notes ?: '-';
        $training->updated_at = now();
        $training->save();

        return response()->json(['message' => 'Status updated']);
    }
}
