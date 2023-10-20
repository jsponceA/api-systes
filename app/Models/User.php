<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, SoftDeletes;
    protected $table = "usuarios";
    protected $primaryKey = "id";

    protected $fillable = [
        "usuario",
        "clave",
        "nombres",
        "apellidos",
        "correo",
        "foto",
        "estado",
        "rol_id"
    ];

    protected $hidden = [
        'clave',
        'remember_token',
    ];

    protected $casts = [
        'clave' => 'hashed',
    ];

    protected $appends = [
        "foto_url"
    ];

    public function getFotoUrlAttribute()
    {
        return !empty($this->foto) ? Storage::url("usuarios/".$this->foto) : null;
    }

    public function rol(): belongsTo
    {
        return $this->belongsTo(Rol::class,"rol_id","id")->withDefault();
    }
}
