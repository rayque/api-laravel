<?php

use App\Models\Perfil;
use Illuminate\Database\Seeder;

class PerfilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Perfil::create(['nome_perfil' => 'Master']);
        Perfil::create(['nome_perfil' => 'Operador']);
    }
}
