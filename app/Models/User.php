<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $appends = ['btn_destroy', 'btn_edit', 'btn_show', 'view_image'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'signature',
        'nik',
        'email',
        'password',
        'company',
        'divisi',
        'unit_kerja',
        'status',
        'jk',
        'telp',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function getBtnDestroyAttribute()
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

    public function getViewImageAttribute()
    {
        if ($this->signature) {
            return asset('storage/signature/' . $this->signature);
        }
        return null;
    }

    // Method khusus untuk mendapatkan HTML signature
    public function getSignatureHtmlAttribute()
    {
        if ($this->signature) {
            return "<img src='" . asset('storage/signature/' . $this->signature) . "' alt='Signature' style='max-width: 50px; max-height: 30px; object-fit: contain; border-radius: 4px;'>";
        }
        return '<span class="text-muted">No signature</span>';
    }


    public function role(): BelongsTo
    {
        return $this->belongsTo(\Idev\EasyAdmin\app\Models\Role::class, 'role_id', 'id');
    }
}
