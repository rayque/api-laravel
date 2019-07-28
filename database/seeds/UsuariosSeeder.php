<?php

use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;


class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $i) {
            $dados = [
                'nome_usuario' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'login' => $faker->unique()->userName,
                'senha' => bcrypt($faker->password),
                'data_creacao' => Carbon::now()->format('Y-m-d'),
                'tempo_expiracao_senha' => $faker->randomNumber(1),
                'cod_autorizacao' => $faker->randomLetter,
                'status_usuario' => $faker->randomElement(['A', 'I']),
                'cod_pessoa' => $faker->randomNumber(4),
            ];

            Usuario::create($dados);
        }
    }
}
