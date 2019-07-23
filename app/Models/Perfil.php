<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $table = 'perfis';
    protected $guarded = [];
    public $timestamps = false;

    public function usuarios()
    {
        return $this->belongsToMany(Usuario::class);
    }
}
