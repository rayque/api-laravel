<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome_usuario', 60);
            $table->string('login', 30)->unique();
            $table->string('email', 60)->unique();
            $table->string('senha', 255);
            $table->timestamp('data_creacao');
            $table->integer('tempo_expiracao_senha');
            $table->char('cod_autorizacao');
            $table->char('status_usuario');
            $table->integer('cod_pessoa');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
