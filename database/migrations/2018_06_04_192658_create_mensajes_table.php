<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMensajesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mensajes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('recibido_id')->unsigned();
            $table->integer('enviado_por')->unsigned();
            $table->integer('conversacion_id')->unsigned();
            $table->string('cuerpo_mensaje');
            $table->string('visto')->default('false');
            $table->string('ha_llegado')->default('false');

            $table->timestamps();
            $table->foreign('recibido_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('enviado_por')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('conversacion_id')->references('id')->on('conversaciones')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mensajes');
    }
}
