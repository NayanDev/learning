<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;

    protected $table = 'materies';
    protected $primaryKey = 'id';
    protected $fillable = ["event_id","file_path","file_type","description"];
    protected $appends = ['btn_delete', 'btn_edit', 'btn_show', 'btn_download'];

    public function getBtnDownloadAttribute()
    {
        $html = "<button type='button' class='btn btn-outline-success btn-sm radius-6' style='margin:1px;' onclick='confirmDownload(\"" . basename((asset($this->file_path))) . "\", \"" . addslashes(asset($this->file_path)) . "\", \"" . $this->id . "\")'>
                    <i class='ti ti-download'></i>
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
        $html = "<a href='" . route('set.materi', ['id' => $this->id]) . "' type='button' class='btn btn-outline-secondary btn-sm radius-6' style='margin:1px;'>
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
