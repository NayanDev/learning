<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';
    protected $primaryKey = 'id';
    protected $fillable = [
        'workshop_id',
        'start_date',
        'end_date',
        'instructor',
        'position',
        'divisi'
    ];
    protected $appends = ['btn_delete', 'btn_edit', 'btn_multilink', 'btn_show'];

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

    public function getBtnMultilinkAttribute()
    {
        $arrLink = [
            ['label' => 'Participant', 'url' => url('participant') . "?event_id=" . $this->id, 'icon' => 'ti ti-users'],
            ['label' => 'Documentation', 'url' => url('documentation') . "?event_id=" . $this->id, 'icon' => 'ti ti-photo'],
            ['label' => 'Materi', 'url' => url('materi') . "?event_id=" . $this->id, 'icon' => 'ti ti-book fw-bold'],
            ['label' => 'Question', 'url' => url('question') . "?year=" . $this->year, 'icon' => 'ti ti-question-mark fw-bold'],
            ['label' => 'Evaluation', 'url' => url('evaluation') . "?event_id=" . $this->id, 'icon' => 'ti ti-pencil'],
            ['label' => 'Certification', 'url' => url('certification') . "?event_id=" . $this->id, 'icon' => 'ti ti-certificate'],
            ['label' => 'Training Report', 'url' => url('training-report') . "?event_id=" . $this->id, 'icon' => 'ti ti-clipboard'],
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
