<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHabitacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('habitaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('numero',10);
            $table->string('detalle',256)->nullable();
            $table->decimal('precio',11,2);
            $table->boolean('estado')->default(1);
            $table->foreign('idpiso')->references('id')->on('pisos');
            $table->foreign('idtipohabitacion')->references('id')->on('tipohabitaciones');
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
        Schema::dropIfExists('habitaciones');
    }
}
