<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aparelho extends Model
{
    protected $table = 'aparelhos';
    protected $guarded = [];
    public $timestamps = false;

    public function aparelhos()
    {
        return $this->belongsToMany(Aparelho::class);
    }

}
