<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalystBody extends Model
{
    protected $table = 'analyst_body';
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
