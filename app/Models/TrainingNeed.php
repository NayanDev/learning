<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingNeed extends Model
{
    use HasFactory;

    protected $table = 'training_needs';
    protected $primaryKey = 'id';
    protected $fillable = ["nik","training_id","workshop_id","user_id","status","approve_by","start_date","end_date","instructur","name","position"];
    protected $appends = ['btn_delete', 'btn_edit', 'btn_show'];

    public function training()
{
    return $this->belongsTo(Training::class); // pastikan namespace model benar
}

public function workshop()
{
    return $this->belongsTo(Workshop::class); // pastikan namespace model benar
}

public function user()
{
    return $this->belongsTo(User::class, 'user_id'); // pastikan namespace model benar
}

public function approver()
{
    return $this->belongsTo(User::class); // pastikan namespace model benar
}

public function participants()
{
    return $this->hasMany(TrainingNeedParticipant::class, 'need_head_id');
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
        $html = "<a href='" . url('training-need-participant') . "?header=" . $this->id . "' class='btn btn-outline-secondary btn-sm radius-6' style='margin:1px;'>
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
