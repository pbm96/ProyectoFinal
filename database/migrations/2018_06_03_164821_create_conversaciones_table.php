<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConversacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('usuario_1')->unsigned();
            $table->integer('usuario_2')->unsigned();
            $table->string('conversacion_borrada_usuario_1')->default('false');
            $table->string('conversacion_borrada_usuario_2')->default('false');

            $table->timestamps();
            $table->foreign('usuario_1')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('usuario_2')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conversaciones');
    }
}
