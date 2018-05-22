<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosVendidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos_vendidos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('producto_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned();
            $table->integer('vendido_a')->unsigned();
            $table->integer('precio_venta');
            $table->integer('valoracion_venta_vendedor')->nullable();
            $table->integer('valoracion_venta_comprador')->nullable();
            $table->string('comentario_venta_comprador')->nullable();
            $table->string('comentario_venta_vendedor')->nullable();
            $table->string('notificacion')->default('true');


            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('set null');
            $table->foreign('vendido_a')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('productos_vendidos');
    }
}
