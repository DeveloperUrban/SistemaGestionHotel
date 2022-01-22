<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecepcionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recepciones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_habitacion')->unsigned();
            $table->integer('id_cliente')->unsigned();
            $table->date('fecha_ingreso');
            $table->date('fecha_salida');
            $table->integer('numero_noches');
            $table->decimal('total_recepcion',11,2);
            $table->string('tipo_pago');
            $table->integer('numero_adultos');
            $table->integer('numero_ninos');
            $table->string('estado',20);
            $table->foreign('id_habitacion')->references('id')->on('habitaciones');
            $table->foreign('id_cliente')->references('id')->on('personas');

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
        Schema::dropIfExists('recepciones');
    }
}
