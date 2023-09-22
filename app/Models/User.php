<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, SoftDeletes;
    protected $table = "usuarios";
    protected $primaryKey = "id";

    protected $fillable = [
        "usuario",
        "clave",
        "nombre",
        "apellidos",
        "correo",
        "foto",
        "estado",
    ];

    protected $hidden = [
        'clave',
        'remember_token',
    ];

    protected $casts = [
        'clave' => 'hashed',
    ];
}
