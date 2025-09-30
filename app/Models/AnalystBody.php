<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalystBody extends Model
{
    protected $table = 'analyst_bodys';
    protected $primaryKey = 'id';
    protected $fillable = [
        'analyst_head_id',
        'position',
        'personil',
        'qualification',
        'general',
        'technic',
    ];
}
