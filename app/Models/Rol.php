<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rol extends Model
{
    protected $table = "roles";
    protected $primaryKey = "id";
    public $timestamps = false;

    public function usuarios(): HasMany
    {
        return $this->hasMany(User::class,"rol_id","id");
    }
}
