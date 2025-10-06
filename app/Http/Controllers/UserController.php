<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Idev\EasyAdmin\app\Helpers\Constant;
use Idev\EasyAdmin\app\Http\Controllers\UserController as BaseUserController;
use Idev\EasyAdmin\app\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Idev\EasyAdmin\app\Helpers\Validation;
use Illuminate\Support\Facades\Validator;

class UserController extends BaseUserController
{
    protected $modelClass = User::class;
    protected $title;
    protected $generalUri;
    protected $arrPermission;
    protected $actionButtons;
    protected $tableHeaders;
    protected $importScripts;
    protected $importStyles;

    public function __construct()
    {
        parent::__construct();

        $this->title = 'User';
        $this->generalUri = 'user';
        $this->arrPermission = [];
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_destroy'];
        $this->importScripts = [
            ['source' => asset('vendor/select2/select2.min.js')],
            ['source' => asset('vendor/select2/select2-initialize.js')]
        ];
        $this->importStyles = [
            ['source' => asset('vendor/select2/select2.min.css')],
            ['source' => asset('vendor/select2/select2-style.css')]
        ];

        $this->tableHeaders = [
            ['name' => 'No', 'column' => '#', 'order' => true],
            ['name' => 'Name', 'column' => 'name', 'order' => true],
            ['name' => 'Email', 'column' => 'email', 'order' => true],
            ['name' => 'Company', 'column' => 'company', 'order' => true],
            ['name' => 'Department', 'column' => 'divisi', 'order' => true],
            ['name' => 'Unit Kerja', 'column' => 'unit_kerja', 'order' => true],
            ['name' => 'Status', 'column' => 'status', 'order' => true],
            ['name' => 'Gender', 'column' => 'jk', 'order' => true],
            ['name' => 'Phone', 'column' => 'telp', 'order' => true],
            ['name' => 'NIK', 'column' => 'nik', 'order' => true],
            ['name' => 'Signature', 'column' => 'signature', 'order' => true],
            ['name' => 'Role', 'column' => 'role_name', 'order' => true],
            ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
            ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];
    }

    public function index()
    {
        $moreActions = [
            [
                'key' => 'import-excel-default',
                'name' => 'Import Excel',
                'html_button' => "<button id='import-excel' type='button' class='btn btn-sm btn-info radius-6' href='#' data-bs-toggle='modal' data-bs-target='#modalImportDefault' title='Import Excel' ><i class='ti ti-upload'></i></button>"
            ],
            [
                'key' => 'export-excel-default',
                'name' => 'Export Excel',
                'html_button' => "<a id='export-excel' class='btn btn-sm btn-success radius-6' target='_blank' href='" . url($this->generalUri . '-export-excel-default') . "'  title='Export Excel'><i class='ti ti-cloud-download'></i></a>"
            ],
            [
                'key' => 'export-pdf-default',
                'name' => 'Export Pdf',
                'html_button' => "<a id='export-pdf' class='btn btn-sm btn-danger radius-6' target='_blank' href='" . url($this->generalUri . '-export-pdf-default') . "' title='Export PDF'><i class='ti ti-file'></i></a>"
            ],
        ];

        $permissions = (new Constant())->permissionByMenu($this->generalUri);
        $data['permissions'] = $permissions;
        $data['importScripts'] = $this->importScripts;
        $data['importStyles'] = $this->importStyles;
        $data['more_actions'] = $moreActions;
        $data['table_headers'] = $this->tableHeaders;
        $data['title'] = $this->title;
        $data['uri_key'] = $this->generalUri;
        $data['uri_list_api'] = route($this->generalUri . '.listapi');
        $data['uri_create'] = route($this->generalUri . '.create');
        $data['url_store'] = route($this->generalUri . '.store');
        $data['fields'] = $this->fields();
        $data['edit_fields'] = $this->fields();
        $data['actionButtonViews'] = [
            'easyadmin::backend.idev.buttons.delete',
            'easyadmin::backend.idev.buttons.edit',
            'easyadmin::backend.idev.buttons.show',
            'easyadmin::backend.idev.buttons.import_default',
        ];
        $data['templateImportExcel'] = "#";
        $data['filters'] = $this->filters();

        $layout = (request('from_ajax') && request('from_ajax') == true) ? 'easyadmin::backend.idev.list_drawer_ajax' : 'easyadmin::backend.idev.list_drawer';

        return view($layout, $data);
    }

    protected function getFilteredApiData()
    {
        try {
            // Step 1: Ambil data lokal sebagai referensi
            $localEmployees = $this->modelClass::all();

            // Index data lokal berdasarkan NIK
            $localByNik = $localEmployees->keyBy('nik');

            // Step 2: Ambil data dari API eksternal
            $response = Http::acceptJson()->get('https://simco.sampharindogroup.com/api/pegawai');

            $filteredApiData = [];

            if ($response->successful()) {
                $apiEmployees = $response->json();

                if (is_array($apiEmployees)) {
                    foreach ($apiEmployees as $apiItem) {
                        $nik = $apiItem['nik'] ?? null;

                        if ($nik && $localByNik->has($nik)) {
                            $localData = $localByNik->get($nik);

                            $apiItem['signature'] = $localData->signature ?? null;
                            $apiItem['role_id'] = $localData->role->name ?? null;
                            $apiItem['created_at'] = $localData->created_at ?? null;
                            $apiItem['updated_at'] = $localData->updated_at ?? null;

                            $apiItem['source'] = 'api';

                            $filteredApiData[] = $apiItem;
                        }
                    }
                }
            }

            // Step 3: Paginate hasilnya
            $limit = (int) request()->get('length', 10);
            $start = (int) request()->get('start', 0);
            $page = ($start / $limit) + 1;

            $totalRecords = count($filteredApiData);
            $paginatedData = array_slice($filteredApiData, $start, $limit);

            return [
                'data' => $paginatedData,
                'total' => $totalRecords,
                'per_page' => $limit,
                'current_page' => $page
            ];
        } catch (\Exception $e) {
            Log::error("Gagal mengambil atau memproses data API: " . $e->getMessage());
        }

        return ['data' => [], 'total' => 0];
    }

    protected function defaultDataQuery()
    {
        $filters = [];
        $orThose = null;
        $orderBy = 'users.id';
        $orderState = 'DESC';
        if (request('search')) {
            $orThose = request('search');
        }
        if (request('order')) {
            $orderBy = request('order');
            $orderState = request('order_state');
        }
        if (request('role_id')) {
            $filters[] = ['roles.id', '=', request('role_id')];
        }

        $dataQueries = User::join('roles', 'roles.id', 'users.role_id')
            ->where($filters)
            ->where(function ($query) use ($orThose) {
                $query->where('users.name', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('email', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('company', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('divisi', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('unit_kerja', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('status', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('jk', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('telp', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('roles.name', 'LIKE', '%' . $orThose . '%');
            })
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'users.company',
                'users.divisi',
                'users.unit_kerja',
                'users.status',
                'users.jk',
                'users.telp',
                'users.nik',
                'users.signature',
                'users.created_at',
                'users.updated_at',
                'roles.name as role_name'
            )
            ->orderBy($orderBy, $orderState);

        return $dataQueries;
    }

    public function indexApi()
    {
        $permission = (new Constant)->permissionByMenu($this->generalUri);

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

    protected function filters()
    {
        $kjs = Role::get();

        $arrRole = [];
        $arrRole[] = ['value' => "", 'text' => "All Roles"];
        foreach ($kjs as $key => $kj) {
            $arrRole[] = ['value' => $kj->id, 'text' => $kj->name];
        }

        $fields = [
            [
                'type' => 'select',
                'label' => 'Role',
                'name' => 'role_id',
                'class' => 'col-md-2',
                'options' => $arrRole,
            ],
        ];

        return $fields;
    }

    protected function getEmployeeOptions()
    {
        try {
            $response = Http::acceptJson()->get('https://simco.sampharindogroup.com/api/pegawai');

            if ($response->successful()) {
                $employees = $response->json();
                $options = [];

                if (is_array($employees)) {
                    foreach ($employees as $employee) {
                        if (isset($employee['nik']) && isset($employee['nama'])) {
                            $options[] = [
                                'value' => $employee['nik'],
                                'text'  => $employee['nama'] . ' (' . $employee['nik'] . ')',
                                'email' => $employee['email'] ?? '',
                                'name'  => $employee['nama'] ?? '',
                                'company' => $employee['company'] ?? '',
                                'divisi' => $employee['divisi'] ?? '',
                                'unit_kerja' => $employee['unit_kerja'] ?? '',
                                'status' => $employee['status'] ?? '',
                                'jk' => $employee['jk'] ?? '',
                                'telp' => $employee['telp'] ?? '',
                            ];
                        }
                    }
                }
                return $options;
            }
        } catch (\Exception $e) {
            Log::error("Gagal mengambil data pegawai untuk options: " . $e->getMessage());
        }

        return [];
    }

    protected function fields($mode = "create", $id = '-')
    {
        $edit = null;
        if ($id != '-') {
            $edit = User::where('id', $id)->first();
        }

        $roles = Role::get();
        $arrRole = [];
        foreach ($roles as $key => $role) {
            $arrRole[] = ['value' => $role->id, 'text' => $role->name];
        }

        $employeeOptions = $this->getEmployeeOptions();

        $fields = [
            [
                'type' => 'user',
                'label' => 'Employee',
                'name' => 'nik',
                'class' => 'col-md-12 my-2',
                'value' => (isset($edit)) ? $edit->nik : '',
                'options' => $employeeOptions,
                'placeholder' => 'Pilih Karyawan',
                'filter' => true,
                'autofill' => true // Add this to enable autofill
            ],
            [
                'type' => 'text',
                'label' => 'Name',
                'name' => 'name',
                'class' => 'col-md-12 my-2',
                'value' => (isset($edit)) ? $edit->name : ''
            ],
            [
                'type' => 'text',
                'label' => 'Email',
                'name' => 'email',
                'class' => 'col-md-12 my-2',
                'value' => (isset($edit)) ? $edit->email : ''
            ],
            [
                'type' => 'text',
                'label' => 'Company',
                'name' => 'company',
                'class' => 'col-md-12 my-2',
                'value' => (isset($edit)) ? $edit->company : ''
            ],
            [
                'type' => 'text',
                'label' => 'Divisi',
                'name' => 'divisi',
                'class' => 'col-md-12 my-2',
                'value' => (isset($edit)) ? $edit->divisi : ''
            ],
            [
                'type' => 'text',
                'label' => 'Unit Kerja',
                'name' => 'unit_kerja',
                'class' => 'col-md-12 my-2',
                'value' => (isset($edit)) ? $edit->unit_kerja : ''
            ],
            [
                'type' => 'text',
                'label' => 'Status',
                'name' => 'status',
                'class' => 'col-md-12 my-2',
                'value' => (isset($edit)) ? $edit->status : ''
            ],
            [
                'type' => 'text',
                'label' => 'Gender',
                'name' => 'jk',
                'class' => 'col-md-12 my-2',
                'value' => (isset($edit)) ? $edit->jk : ''
            ],

            [
                'type' => 'text',
                'label' => 'Phone',
                'name' => 'telp',
                'class' => 'col-md-12 my-2',
                'value' => (isset($edit)) ? $edit->telp : ''
            ],
            [
                'type' => 'image',
                'label' => 'Signature',
                'name' => 'signature',
                'class' => 'col-md-12 my-2',
                'value' => (!empty($edit->signature)) ? asset('storage/signature/' . $edit->signature) : null,
            ],
            [
                'type' => 'select',
                'label' => 'Role',
                'name' => 'role_id',
                'class' => 'col-md-12 my-2',
                'value' => (isset($edit)) ? $edit->role_id : '',
                'options' => $arrRole
            ],
            [
                'type' => 'password',
                'label' => 'Password',
                'name' => 'password',
                'class' => 'col-md-12 my-2',
                'value' => 'admin123'
            ],
        ];

        return $fields;
    }

    private function rules($id = null)
    {
        $rules = [
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email,' . $id . ',id',
            // 'email' => 'required|string|unique:users',
            'password' => 'required|string',
        ];

        if ($id != null) {
            unset($rules['password']);
        }

        return $rules;
    }

    public function store(Request $request)
    {

        $rules = $this->rules();
        $name = $request->name;
        $email = $request->email;
        $company = $request->company;
        $divisi = $request->divisi;
        $unit_kerja = $request->unit_kerja;
        $status = $request->status;
        $jk = $request->jk;
        $telp = $request->telp;
        $nik = $request->nik;
        $signature = $request->signature;
        $roleId = $request->role_id;
        $password = $request->password;

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
            $insert = new User();
            $insert->name = $name;
            $insert->email = $email;
            $insert->nik = $nik;
            $insert->company = $company;
            $insert->divisi = $divisi;
            $insert->unit_kerja = $unit_kerja;
            $insert->status = $status;
            $insert->jk = $jk;
            $insert->telp = $telp;
            $insert->signature = $signature;
            $insert->role_id = $roleId;
            $insert->password = bcrypt($password);
            $insert->save();

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
