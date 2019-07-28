<?php

use App\Models\Aparelho;
use App\Models\Perfil;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class RelacionamentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $perfis = Perfil::all()->pluck('id');
        $aparelhos = Aparelho::all()->pluck('id');
        $usuarios = Usuario::all();

        foreach ($usuarios as $usuario) {
            $usuario->perfis()->sync($perfis);
            $usuario->aparelhos()->sync($aparelhos);
        }



    }
}
