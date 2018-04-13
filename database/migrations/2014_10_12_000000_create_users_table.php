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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre','30');
            $table->string('apellido1','30');
            $table->string('apellido2','30')->nullable();
            $table->string('nombre_usuario','15')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('direccion');
            $table->decimal('telefono',9,0)->nullable();
            $table->string('imagen')->nullable();



            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
