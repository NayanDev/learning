<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingNeed extends Model
{
    use HasFactory;

    protected $table = 'training_needs';
    protected $primaryKey = 'id';
    protected $fillable = ['nik', 'training_id', 'workshop_id', 'user_id', 'status', 'approve_by', 'start_date', 'end_date', 'instructur', 'position'];
    protected $appends = ['btn_delete', 'btn_edit', 'btn_show', 'btn_approval'];

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

    public function participants()
    {
        return $this->hasMany(TrainingNeedParticipant::class, 'need_head_id');
    }

    public function workshops()
    {
        return $this->hasMany(NeedWorkshop::class, 'training_need_id');
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

        if ($this->status === "open" && $roleName === "staff") {
            $html = $btn;
            return $html;
        } else if ($this->status === "submit") {
            if ($roleName === "staff") {
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


    public function getBtnEditAttribute()
    {
        $html = "<button type='button' class='btn btn-outline-secondary btn-sm radius-6' style='margin:1px;' data-bs-toggle='offcanvas'  data-bs-target='#drawerEdit' onclick='setEdit(" . json_encode($this->id) . ")'>
                    <i class='ti ti-pencil'></i>
                </button>";

        return $html;
    }


    public function getBtnShowAttribute()
    {
        $html = "<a href='" . url('need-workshop') . "?header=" . $this->id . "' class='btn btn-outline-secondary btn-sm radius-6' style='margin:1px;'>
                <i class='ti ti-eye'></i>
                </a>";
        return $html;
    }


    public function getUpdatedAtAttribute($value)
    {
        return $value ? date("Y-m-d H:i:s", strtotime($value)) : "-";
    }


    public function getCreatedAtAttribute($value)
    {
        return $value ? date("Y-m-d H:i:s", strtotime($value)) : "-";
    }
}
