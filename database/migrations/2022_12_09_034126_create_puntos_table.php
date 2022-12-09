<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePuntosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('puntos', function (Blueprint $table) {
            $table->unsignedSmallInteger('id');
            $table->string('Shape', 5);
            $table->string('FID_stops2', 4);
            $table->decimal('longi', 8, 6);
            $table->decimal('lati', 8, 6);
            $table->string('Punto', 4);
            $table->string('Tipo', 1);
            $table->smallInteger('orden');
            $table->string('PuntoD', 4);
            $table->float('LongiD', 8, 6);
            $table->float('LatiD', 8, 6);
            $table->unsignedBigInteger('recorrido_id')->nullable();
            $table->foreign('recorrido_id')->references('id')->on('recorridos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('puntos');
    }
}
