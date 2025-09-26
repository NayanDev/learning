<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    protected $table = 'trainings';
    protected $primaryKey = 'id';
    protected $fillable = [];
    protected $appends = ['btn_delete', 'btn_edit', 'btn_print', 'btn_multilink'];

    public function getBtnMultilinkAttribute()
    {
        $arrLink = [
            ['label' => 'Detail', 'url' => '#', 'icon' => 'ti ti-eye'],
            ['label' => 'Participant', 'url' => url('training-participant')."?training_id=".$this->id, 'icon' => 'ti ti-users'],
            ['label' => 'Recap Data', 'url' => url('training-recap')."?training_id=".$this->id, 'icon' => 'ti ti-archive'],
            ['label' => 'Training Unplanned', 'url' => url('training-unplanned')."?training_id=".$this->id, 'icon' => 'ti ti-help'],
        ];

        $html = "<button type='button' data-links='".json_encode($arrLink)."' onclick='setMM(this)' title='Navigation' class='btn btn-outline-warning btn-sm radius-6' style='margin:1px;' data-bs-toggle='modal' data-bs-target='#modalMultiLink'>
                    <i class='ti ti-list'></i>
                </button>";

        return $html;
    }

    public function getBtnPrintAttribute()
    {
        $html = "<a id='export-pdf' data-base-url='' class='btn btn-sm btn-outline-primary radius-6' target='_blank' href='".url('training-export-jadwal')."?training_id=".$this->id."' title='Export PDF'><i class='ti ti-file'></i></a>";

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
