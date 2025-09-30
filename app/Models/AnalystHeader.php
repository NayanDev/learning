<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalystHeader extends Model
{
    protected $table = 'analyst_header';
    protected $primaryKey = 'id';
    protected $fillable = [
        'qualification',
        'general',
        'technic',
        'user_id',
        'approve_by',
        'status',
    ];
}
