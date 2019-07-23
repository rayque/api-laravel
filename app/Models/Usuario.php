<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuarios';
    protected $guarded = [];
    public $timestamps = false;

    public function aparelhos()
    {
        return $this->belongsToMany(Aparelho::class);
    }

    public function perfis()
    {
        return $this->belongsToMany(Perfil::class);
    }
}
