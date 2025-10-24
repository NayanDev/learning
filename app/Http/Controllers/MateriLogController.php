<?php

namespace App\Http\Controllers;

use App\Models\MateriLog;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MateriLogController extends DefaultController
{
    protected $modelClass = MateriLog::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    // protected $arrPermissions;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Materi Log';
        $this->generalUri = 'materi-log';
        // $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
                    ['name' => 'No', 'column' => '#', 'order' => true],
                    ['name' => 'Materi id', 'column' => 'materi_id', 'order' => true],
                    ['name' => 'User id', 'column' => 'user_id', 'order' => true],
                    ['name' => 'Action', 'column' => 'action', 'order' => true],
                    ['name' => 'Count', 'column' => 'count', 'order' => true], 
                    ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
                    ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [ 
            'primaryKeys' => ['materi_id'],
            'headers' => [
                    ['name' => 'Materi id', 'column' => 'materi_id'],
                    ['name' => 'User id', 'column' => 'user_id'],
                    ['name' => 'Action', 'column' => 'action'],
                    ['name' => 'Count', 'column' => 'count'], 
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
                        'label' => 'Materi id',
                        'name' =>  'materi_id',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('materi_id', $id),
                        'value' => (isset($edit)) ? $edit->materi_id : ''
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
                        'label' => 'Action',
                        'name' =>  'action',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('action', $id),
                        'value' => (isset($edit)) ? $edit->action : ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Count',
                        'name' =>  'count',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('count', $id),
                        'value' => (isset($edit)) ? $edit->count : ''
                    ],
        ];
        
        return $fields;
    }


    protected function rules($id = null)
    {
        $rules = [
                    'materi_id' => 'required|string',
                    'user_id' => 'required|string',
                    'action' => 'required|string',
                    'count' => 'required|string',
        ];

        return $rules;
    }

    public function countDownload(Request $request)
    {
        $request->validate([
            'materi_id' => 'required|integer|exists:materies,id',
        ]);

        $userId = Auth::id();
        $materiId = $request->materi_id;

        // Cari apakah user sudah pernah download materi ini
        $log = MateriLog::where('materi_id', $materiId)
                        ->where('user_id', $userId)
                        ->where('action', 'download')
                        ->first();

        if ($log) {
            // Sudah pernah download → tambah count
            $log->increment('count');
            $message = "Download ke-{$log->count} untuk materi ini.";
        } else {
            // Belum pernah download → buat baru
            $log = MateriLog::create([
                'materi_id' => $materiId,
                'user_id'   => $userId,
                'action'    => 'download',
                'count'     => 1,
            ]);
            $message = "Download pertama untuk materi ini.";
        }

        return response()->json([
            'status'  => true,
            'message' => $message,
            'count'   => $log->count,
        ]);
    }

    public function countLog(Request $request)
    {
        $request->validate([
            'materi_id' => 'required|exists:materi_logs,id',
            'action' => 'required|string'
        ]);

        $userId = Auth::user()->id; // pastikan user login

        $log = MateriLog::where('materi_id', $request->materi_id)
            ->where('user_id', $userId)
            ->where('action', $request->action)
            ->first();

        if ($log) {
            $log->increment('count');
        } else {
            MateriLog::create([
                'materi_id' => $request->materi_id,
                'user_id' => $userId,
                'action' => $request->action,
                'count' => 1,
            ]);
        }

        return response()->json(['message' => 'Log saved']);
    }

}