<?php

use App\Models\Aparelho;
use App\Models\Usuario;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class AparelhoSeeder extends Seeder
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
                'descricao_aparelho' => $faker->text(10),
                'codigo_aparelho' => $faker->randomNumber(5),
            ];
            Aparelho::create($dados);
        }
    }
}
