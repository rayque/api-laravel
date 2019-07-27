<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usuario extends Model
{
    use SoftDeletes;

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
