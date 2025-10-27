<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingNewEmployee extends Model
{
    use HasFactory;

    protected $table = 'training_new_employees';
    protected $primaryKey = 'id';
    protected $fillable = ["workshop_id", "user_id", "year", "letter_number", "organizer", "speaker", "start_date", "end_date", "divisi", "token", "token_expired", "instructor", "location", "approve_by", "created_date", "status", "notes"];
    protected $appends = ['btn_delete', 'btn_edit', 'btn_show', 'btn_multilink'];

    public function workshop()
    {
        return $this->belongsTo(Workshop::class);
    }

    public function getBtnMultilinkAttribute()
    {
        $arrLink = [
            ['label' => 'Participant', 'url' => url('training-new-participant') . "?test_employee_id=" . $this->id, 'icon' => 'ti ti-users'],
            ['label' => 'QR Code', 'url' => route('set.test', ['id' => $this->id]), 'icon' => 'ti ti-qrcode'],
            // ['label' => 'Materi', 'url' => url('materi') . "?event_id=" . $this->id, 'icon' => 'ti ti-book fw-bold'],
            ['label' => 'Question', 'url' => url('question') . "?test_employee_id=" . $this->id, 'icon' => 'ti ti-question-mark fw-bold'],
            // ['label' => 'Evaluation', 'url' => url('evaluation') . "?event_id=" . $this->id, 'icon' => 'ti ti-pencil'],
            // ['label' => 'Certification', 'url' => url('certification') . "?event_id=" . $this->id, 'icon' => 'ti ti-certificate'],
            // ['label' => 'Documentation', 'url' => url('documentation') . "?event_id=" . $this->id, 'icon' => 'ti ti-photo'],
            // ['label' => 'Training Report', 'url' => url('training-report') . "?event_id=" . $this->id, 'icon' => 'ti ti-clipboard'],
        ];
        $html = "<button type='button' data-links='" . json_encode($arrLink) . "' onclick='setMM(this)' title='Navigation' class='btn btn-outline-warning btn-sm radius-6' style='margin:1px;' data-bs-toggle='modal' data-bs-target='#modalMultiLink'>
                    <i class='ti ti-list'></i>
                </button>";

        return $html;
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
