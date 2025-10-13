<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalystHeader extends Model
{
    protected $table = 'analyst_headers';
    protected $primaryKey = 'id';
    protected $fillable = [
        'training_id',
        'qualification',
        'general',
        'technic',
        'user_id',
        'approve_by',
        'status',
        'divisi',
        'notes'
    ];

    protected $appends = ['btn_delete', 'btn_show', 'btn_approval'];

    public function training()
    {
        return $this->belongsTo(Training::class, 'training_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approve_by');
    }

    public function getBtnApprovalAttribute()
    {
        $data = [
            'id' => $this->id,
            'status' => $this->status,
            'notes' => $this->notes,
        ];

        $roleName = auth()->user()->role->name;

        $btn = "<button type='button' class='btn btn-outline-primary btn-sm radius-6' style='margin:1px;' 
                data-bs-toggle='modal'  
                data-bs-target='#modalApproval' 
                onclick='setApproval(" . json_encode($data) . ")'>
                <i class='ti ti-check'></i>
            </button>";
        $btnOff = "<button type='button' class='btn btn-outline-success btn-sm radius-6' style='margin:1px;'>
                <i class='ti ti-check'></i>
            </button>";
        $pdf = "<a id='export-pdf' class='btn btn-sm btn-outline-secondary radius-6' target='_blank' href='" . url('training-analyst-pdf') . "?header=" . $this->id . "' title='Export PDF'><i class='ti ti-file'></i></a>";

        if ($this->status === "open" && ($roleName === "staff" || $roleName === "admin")) {
            $html = $btn;
            return $html;
        } else if ($this->status === "submit") {
            if ($roleName === "staff" || $roleName === "admin") {
                $html = $btnOff;
                return $html;
            } else if ($roleName === "manager") {
                $html = $btn;
                return $html;
            }
        } else if ($this->status === "approve") {
            $html = $pdf;
            return $html;
        }
    }

    public function getBtnDeleteAttribute()
    {
        $html = "<button type='button' class='btn btn-outline-danger btn-sm radius-6' style='margin:1px;' data-bs-toggle='modal' data-bs-target='#modalDelete' onclick='setDelete(" . json_encode($this->id) . ")'>
                    <i class='ti ti-trash'></i>
                </button>";

        return $html;
    }

    public function getBtnShowAttribute()
    {
        $html = "<a href='" . url('training-analyst-form') . "?header=" . $this->id . "' class='btn btn-outline-secondary btn-sm radius-6' style='margin:1px;'>
                <i class='ti ti-eye'></i>
                </a>";
        return $html;
    }
}
