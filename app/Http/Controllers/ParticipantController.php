<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Participant;
use App\Models\User;
use Idev\EasyAdmin\app\Helpers\Constant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Idev\EasyAdmin\app\Helpers\Validation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;
use Illuminate\Support\Facades\Auth;

class ParticipantController extends DefaultController
{
    protected $modelClass = Participant::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    // protected $arrPermissions;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Participant';
        $this->generalUri = 'participant';
        // $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
            ['name' => 'No', 'column' => '#', 'order' => true],
            ['name' => 'Name', 'column' => 'name', 'order' => true],
            ['name' => 'Divisi', 'column' => 'divisi', 'order' => true],
            ['name' => 'Sign Ready', 'column' => 'in_ready', 'order' => true],
            ['name' => 'Sign Present', 'column' => 'in_present', 'order' => true],
            ['name' => 'Out Present', 'column' => 'out_present', 'order' => true],
            ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
            ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [
            'primaryKeys' => ['name'],
            'headers' => [
                ['name' => 'Name', 'column' => 'name'],
                ['name' => 'Divisi', 'column' => 'divisi'],
                ['name' => 'Signature', 'column' => 'signature'],
                ['name' => 'Note', 'column' => 'note'],
                ['name' => 'Event id', 'column' => 'event_id'],
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
                'type' => 'participant',
                'label' => 'Participant',
                'name' => 'name',
                'class' => 'col-md-12 my-2',
                'key' => 'nik',
                'ajaxUrl' => url('participant-ajax'),
                'table_headers' => ['Name', 'Department', 'Position', 'NIK']
            ],
            [
                'type' => 'hidden',
                'label' => 'Signature',
                'name' =>  'signature',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('signature', $id),
                'value' => (isset($edit)) ? $edit->signature : ''
            ],
            [
                'type' => 'hidden',
                'label' => 'Note',
                'name' =>  'note',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('note', $id),
                'value' => (isset($edit)) ? $edit->note : ''
            ],
            [
                'type' => 'hidden',
                'label' => 'Event id',
                'name' =>  'event_id',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('event_id', $id),
                'value' => (isset($edit)) ? $edit->event_id : request('event_id')
            ],
        ];

        return $fields;
    }


    protected function rules($id = null)
    {
        $rules = [];

        return $rules;
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

        $params = "";
        if (request('event_id')) {
            $params = "?event_id=" . request('event_id');
        }

        $status = "open";
        if (request('event_id')) {
            $data = Event::findOrfail(request('event_id'));
            $status = $data->status;
        }

        $permissions = (new Constant())->permissionByMenu($this->generalUri);
        $data['permissions'] = $permissions;
        $data['more_actions'] = $moreActions;
        $data['table_headers'] = $this->tableHeaders;
        $data['title'] = $this->title;
        $data['uri_key'] = $this->generalUri;
        $data['uri_list_api'] = route($this->generalUri . '.listapi') . $params;
        $data['uri_create'] = route($this->generalUri . '.create');
        $data['url_store'] = route($this->generalUri . '.store');
        $data['fields'] = $this->fields();
        $data['edit_fields'] = $this->fields();
        $data['actionButtonViews'] = $this->actionButtonViews;
        $data['templateImportExcel'] = "#";
        $data['filters'] = $this->filters();
        $data['drawerExtraClass'] = 'w-50';
        $data['status'] = $status;

        $layout = (request('from_ajax') && request('from_ajax') == true) ? 'easyadmin::backend.idev.list_drawer_ajax' : 'backend.idev.list_drawer_participant';

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
        if (request('event_id')) {
            $filters[] = ['event_id', '=', request('event_id')];
        }

        $dataQueries = $this->modelClass::where($filters)
            ->where(function ($query) use ($orThose) {
                $efc = ['#', 'created_at', 'updated_at', 'id'];

                foreach ($this->tableHeaders as $key => $th) {
                    if (array_key_exists('search', $th) && $th['search'] == false) {
                        $efc[] = $th['column'];
                    }
                    if (!in_array($th['column'], $efc)) {
                        if ($key == 0) {
                            $query->where($th['column'], 'LIKE', '%' . $orThose . '%');
                        } else {
                            $query->orWhere($th['column'], 'LIKE', '%' . $orThose . '%');
                        }
                    }
                }
            })
            ->orderBy($orderBy, $orderState);

        return $dataQueries;
    }

    protected function store(Request $request)
    {
        try {
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

            // Decode JSON string dari input hidden
            $selectedParticipants = json_decode($request->name, true);
            $token = Str::random(32);

            if (empty($selectedParticipants)) {
                throw new Exception('Tidak ada peserta yang dipilih');
            }

            // Debug log
            Log::info('Selected Participants:', ['participants' => $selectedParticipants]);

            // Simpan data participant dengan semua field
            foreach ($selectedParticipants as $participant) {
                $insert = new Participant();

                if (is_array($participant)) {
                    // Jika sudah berupa array dengan data lengkap
                    $insert->company = $participant['company'] ?? '';
                    $insert->nik = $participant['nik'] ?? '';
                    $insert->name = $participant['nama'] ?? $participant['name'] ?? '';
                    $insert->divisi = $participant['divisi'] ?? '';
                    $insert->unit_kerja = $participant['unit_kerja'] ?? '';
                    $insert->status = $participant['status'] ?? '';
                    $insert->jk = $participant['jk'] ?? '';
                    $insert->email = $participant['email'] ?? '';
                    $insert->telp = $participant['telp'] ?? '';
                } else {
                    // Jika hanya string nama (fallback untuk kompatibilitas)
                    $insert->company = '';
                    $insert->nik = '';
                    $insert->name = $participant;
                    $insert->divisi = '';
                    $insert->unit_kerja = '';
                    $insert->status = '';
                    $insert->jk = '';
                    $insert->email = '';
                    $insert->telp = '';
                }

                $insert->event_id = $request->event_id;
                $insert->save();
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'alert' => 'success',
                'message' => 'Data berhasil disimpan',
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error storing training needs: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function generateUser($event_id)
    {
        try {
            // Ambil data event & peserta
            $participants = Participant::where('event_id', $event_id)->get();
            $event = Event::findOrFail($event_id);

            $created = 0;
            $skipped = 0;

            foreach ($participants as $p) {
                // Cek jika email kosong, langsung skip
                if (!$p->email) {
                    $skipped++;
                    continue;
                }

                // Cek apakah email sudah terdaftar
                $exists = User::where('nik', $p->nik)
                    ->orWhere('email', $p->email)
                    ->exists();

                if ($exists) {
                    $skipped++;
                    continue;
                }

                // Buat user baru
                User::create([
                    'name'       => $p->name,
                    'email'      => $p->email,
                    'company'    => $p->company,
                    'divisi'     => $p->divisi,
                    'unit_kerja' => $p->unit_kerja,
                    'status'     => $p->status,
                    'jk'         => $p->jk,
                    'telp'       => $p->telp,
                    'nik'        => $p->nik,
                    'role_id'    => 4,
                    'password'   => bcrypt('pelatihan' . $event->year),
                ]);

                $created++;
            }

            // Jika dipanggil dari fetch(), kembalikan JSON
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'created' => $created,
                    'skipped' => $skipped,
                ]);
            }

            // Jika dipanggil dari form biasa
            return back()->with('success', "✅ User berhasil dibuat: $created | ⏩ Dilewati: $skipped");
        } catch (\Exception $e) {
            // Log error ke laravel.log
            Log::error('Generate User Error: ' . $e->getMessage());

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ], 500);
            }

            return back()->with('error', '❌ Gagal generate user: ' . $e->getMessage());
        }
    }

    public function attendance()
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

        $token = request('token');

        $user = Auth::user();

        $participant = Participant::where('nik', $user->nik)
            ->whereHas('event', function ($query) use ($token) {
                $query->where('token', $token);
            })
            ->with('event') // kalau kamu ingin data event juga
            ->first();

        if (! $participant) {
            abort(403, 'token tidak valid');
        }

        $permissions = (new Constant())->permissionByMenu($this->generalUri);
        $data['permissions'] = $permissions;
        $data['more_actions'] = $moreActions;
        $data['table_headers'] = $this->tableHeaders;
        $data['title'] = $this->title;
        $data['uri_key'] = $this->generalUri;
        $data['uri_list_api'] = route($this->generalUri . '.listapi');
        $data['uri_create'] = route($this->generalUri . '.create');
        $data['url_store'] = route($this->generalUri . '.store');
        $data['fields'] = $this->fields();
        $data['edit_fields'] = $this->fields();
        $data['actionButtonViews'] = $this->actionButtonViews;
        $data['templateImportExcel'] = "#";
        $data['filters'] = $this->filters();
        $data['drawerExtraClass'] = 'w-50';
        $data['data_query'] = $participant;

        $layout = (request('from_ajax') && request('from_ajax') == true) ? 'easyadmin::backend.idev.list_drawer_ajax' : 'backend.idev.attendance_form';

        return view($layout, $data);
    }

    public function attendanceFormReady(Request $request)
    {
        try {
            $user = Auth::user();

            $participant = Participant::with('event')
                ->where('nik', $user->nik)
                ->first();

            if (!$participant) {
                return response()->json([
                    'status' => false,
                    'message' => 'Peserta tidak ditemukan atau token tidak valid.'
                ], 404);
            }

            DB::beginTransaction();

            $participant->sign_ready = $user->id;
            // $participant->sign_present = $user->id;
            $participant->in_ready = now();
            // $participant->in_present = now();
            $participant->updated_at = now();
            $participant->save();

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Status updated successfully'
            ]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function attendanceForm(Request $request, $token)
    {
        try {
            $token = request('token');
            $user = Auth::user();

            $participant = Participant::with('event')
                ->where('nik', $user->nik)
                ->whereHas('event', function ($query) use ($token) {
                    $query->where('token', $token);
                })
                ->first();

            if (!$participant) {
                return response()->json([
                    'status' => false,
                    'message' => 'Peserta tidak ditemukan atau token tidak valid.'
                ], 404);
            }

            DB::beginTransaction();

            // $participant->sign_ready = $user->id;
            $participant->sign_present = $user->id;
            // $participant->in_ready = now();
            $participant->in_present = now();
            $participant->updated_at = now();
            $participant->save();

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Status updated successfully'
            ]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function splpdf(Request $request)
    {
        $data = [
            'title' => 'Surat Perintah Lembaga',
            'date' => now()->format('d M Y'),
            'participant' => Event::with(['user', 'approver', 'participants', 'signpresent', 'signready'])
                ->where('id', $request->event_id)
                ->first(),
            'event' => Event::find($request->event_id)
        ];

        $pdf = Pdf::loadView('pdf.surat_perintah_pelatihan', $data)
            ->setPaper('A4', 'portrait');

        return $pdf->stream('surat_perintah_pelatihan.pdf');
    }

    public function presentpdf(Request $request)
    {
        $data = [
            'title' => 'Presentasi Peserta',
            'date' => now()->format('d M Y'),
            'participant' => Event::with(['user', 'approver', 'participants', 'signpresent', 'signready'])
                ->where('id', $request->event_id)
                ->first(),
            'event' => Event::find($request->event_id)
        ];

        $pdf = Pdf::loadView('pdf.daftar_hadir_pelatihan', $data)
            ->setPaper('A4', 'portrait');

        return $pdf->stream('daftar_hadir_pelatihan.pdf');
    }
}
