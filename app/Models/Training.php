<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    protected $table = 'trainings';
    protected $primaryKey = 'id';
    protected $fillable = ['year', 'end_date', 'status', 'description', 'user_id', 'notes',];
    protected $appends = ['btn_delete', 'btn_edit', 'btn_multilink', 'btn_approval'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approve_by');
    }

    public function getBtnMultilinkAttribute()
    {
        $arrLink = [
            ['label' => 'Training Detail', 'url' => url('training-detail') . "?training_id=" . $this->id, 'icon' => 'ti ti-eye'],
            ['label' => 'Training Analyst', 'url' => url('training-analyst') . "?training_id=" . $this->id, 'icon' => 'ti ti-users'],
            ['label' => 'Training Needs', 'url' => url('training-need') . "?training_id=" . $this->id, 'icon' => 'ti ti-archive'],
            ['label' => 'Training Schedule', 'url' => url('training-schedule') . "?year=" . $this->year, 'icon' => 'ti ti-calendar'],
            ['label' => 'Training Unplanned', 'url' => url('training-unplanned') . "?training_id=" . $this->id, 'icon' => 'ti ti-help'],
        ];

        $html = "<button type='button' data-links='" . json_encode($arrLink) . "' onclick='setMM(this)' title='Navigation' class='btn btn-outline-warning btn-sm radius-6' style='margin:1px;' data-bs-toggle='modal' data-bs-target='#modalMultiLink'>
                    <i class='ti ti-list'></i>
                </button>";

        return $html;
    }

    public function getBtnApprovalAttribute()
    {
        $data = [
            'id' => $this->id,
            'status' => $this->status,
            'year' => $this->year,
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
        $pdf = "<a id='export-pdf' class='btn btn-sm btn-outline-secondary radius-6' target='_blank' href='" . url('training-schedule-pdf') . "?year=" . $this->year . "' title='Export PDF'><i class='ti ti-file'></i></a>";

        if (($this->status === "open" || $this->status === "reject") && $roleName === "admin") {
            $html = $btn;
            return $html;
        } else if ($this->status === "submit") {
            if ($roleName === "admin") {
                $html = $btnOff;
                return $html;
            } else if ($roleName === "manager") {
                $html = $btn;
                return $html;
            }
        } else if ($this->status === "approve") {
            if ($roleName === "admin") {
                $html = $btn;
                return $html;
            } else if ($roleName === "manager") {
                $html = $btnOff;
                return $html;
            } else if ($roleName === "direktur") {
                $html = $btn;
                return $html;
            }
        } else if ($this->status === "close") {
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
        $html = "<button type='button' class='btn btn-outline-secondary btn-sm radius-6' style='margin:1px;' onclick='setShowPreview(" . json_encode($this->id) . ")'>
                <i class='ti ti-eye'></i>
                </button>";
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
