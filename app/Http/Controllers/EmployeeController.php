<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Support\Facades\Log;
use Idev\EasyAdmin\app\Helpers\Constant;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;
use Illuminate\Support\Facades\Http;

class EmployeeController extends DefaultController
{
    protected $modelClass = Employee::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    // protected $arrPermissions;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Employee';
        $this->generalUri = 'employee';
        // $this->arrPermissions = [];
        $this->actionButtons = ['btn_delete'];

        $this->tableHeaders = [
                    ['name' => 'No', 'column' => '#', 'order' => true],
                    ['name' => 'name', 'column' => 'nama', 'order' => true],
                    ['name' => 'department', 'column' => 'divisi', 'order' => true],
                    ['name' => 'work unit', 'column' => 'unit_kerja', 'order' => true],
                    ['name' => 'status', 'column' => 'status', 'order' => true],
                    ['name' => 'Gender', 'column' => 'jk', 'order' => true],
                    ['name' => 'email', 'column' => 'email', 'order' => true],
                    ['name' => 'phone', 'column' => 'telp', 'order' => true],
                    ['name' => 'company', 'column' => 'company', 'order' => true],
                    ['name' => 'signature', 'column' => 'signature', 'order' => true],
                    ['name' => 'NIK', 'column' => 'nik', 'order' => true],
        ];

        $this->importExcelConfig = [ 
            'primaryKeys' => ['signature'],
            'headers' => [
                    ['name' => 'Signature', 'column' => 'signature'],
                    ['name' => 'Employee id', 'column' => 'employee_id'], 
            ]
        ];
    }

    protected function getEmployeeOptions()
    {
        try {
            $response = Http::acceptJson()->get('https://simco.sampharindogroup.com/api/pegawai');

            if ($response->successful()) {
                // Langsung ambil body JSON karena responsnya adalah array
                $employees = $response->json(); 
                $options = [];

                if (is_array($employees)) {
                    foreach ($employees as $employee) {
                        // PERBAIKAN: Gunakan 'nik' sebagai value dan 'nama' sebagai text
                        if (isset($employee['nik']) && isset($employee['nama'])) {
                            $options[] = [
                                'value' => $employee['nik'],
                                'text'  => $employee['nama'] . ' (' . $employee['nik'] . ')' // Menambahkan NIK di teks agar lebih unik
                            ];
                        }
                    }
                }
                return $options;
            }
        } catch (\Exception $e) {
            Log::error("Gagal mengambil data pegawai untuk options: " . $e->getMessage());
        }

        return []; // Kembalikan array kosong jika gagal
    }

    protected function getFilteredApiData()
    {
        try {
            // Langkah 1: Ambil SEMUA NIK dari database lokal. Ini akan menjadi filter kita.
            $localNiks = $this->modelClass::pluck('nik')->all();

            // Jika tidak ada NIK di database lokal, tidak ada yang perlu ditampilkan.
            if (empty($localNiks)) {
                return ['data' => [], 'total' => 0]; // Kembalikan struktur kosong
            }

            // Langkah 2: Ambil SEMUA data dari API.
            $response = Http::acceptJson()->get('https://simco.sampharindogroup.com/api/pegawai');

            if ($response->successful()) {
                $apiEmployees = $response->json();
                $filteredData = [];

                // Langkah 3: Saring data API.
                // Simpan hanya pegawai API yang NIK-nya ada di dalam $localNiks.
                if (is_array($apiEmployees)) {
                    foreach ($apiEmployees as $apiEmployee) {
                        if (in_array($apiEmployee['nik'], $localNiks)) {
                            $filteredData[] = $apiEmployee;
                        }
                    }
                }
                
                // Langkah 4: Lakukan Paginasi Manual terhadap data yang sudah disaring.
                $limit = (int) request()->get('length', 10);
                $start = (int) request()->get('start', 0);
                $page = ($start / $limit) + 1;
                
                $totalRecords = count($filteredData);
                
                // Ambil "potongan" data untuk halaman saat ini menggunakan array_slice.
                $paginatedData = array_slice($filteredData, $start, $limit);
                
                // Langkah 5: Susun ulang menjadi format yang mirip dengan respons API asli.
                return [
                    'data' => $paginatedData,
                    'total' => $totalRecords,
                    'per_page' => $limit,
                    'current_page' => $page
                ];
            }
        } catch (\Exception $e) {
            Log::error("Gagal mengambil atau memfilter data API: " . $e->getMessage());
        }

        return ['data' => [], 'total' => 0]; // Kembalikan struktur kosong jika gagal
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

        // --- CUKUP UBAH BARIS INI ---
        $dataQueries = $this->getFilteredApiData();
        // ---------------------------

        // Kode di bawah ini tidak perlu diubah sama sekali.
        if (!is_array($dataQueries)) {
            $dataQueries = json_decode($dataQueries, true);
        }
        
        // ... (sisa kode Anda tetap sama) ...
        $datas['extra_buttons'] = $eb;
        $datas['data_columns'] = $data_columns;
        $datas['data_queries'] = $dataQueries;
        $datas['data_permissions'] = $permission;
        $datas['uri_key'] = $this->generalUri;

        return $datas;
    }

    protected function fields($mode = "create", $id = '-')
    {
        $edit = null;
        if ($id != '-') {
            $edit = $this->modelClass::where('id', $id)->first();
        }

        $employeeOptions = $this->getEmployeeOptions();

        $fields = [
                    [
                        'type' => 'text',
                        'label' => 'Signature',
                        'name' =>  'signature',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('signature', $id),
                        'value' => (isset($edit)) ? $edit->signature : ''
                    ],
                    [
                        'type' => 'select2',
                        'label' => 'Employee', // Label bisa diubah agar lebih deskriptif
                        'name' => 'nik',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('nik', $id),
                        'value' => (isset($edit)) ? $edit->nik : '',
                        
                        // Tambahkan key 'options' dengan data yang sudah diformat
                        'options' => $employeeOptions,
                        
                        // (Optional) Tambahkan placeholder untuk UX yang lebih baik
                        'placeholder' => 'Pilih Karyawan'
                    ],
        ];
        
        return $fields;
    }

    protected function rules($id = null)
    {
        $rules = [
                    'nik' => 'required|string',
        ];

        return $rules;
    }

}
