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
    ];

    protected $appends = ['btn_delete', 'btn_show'];

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
