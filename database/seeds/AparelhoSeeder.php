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
        Aparelho::create(['descricao_aparelho' => 'IPhone 10', 'codigo_aparelho' => '123']);
        Aparelho::create(['descricao_aparelho' => 'S10', 'codigo_aparelho' => '456']);
    }
}
