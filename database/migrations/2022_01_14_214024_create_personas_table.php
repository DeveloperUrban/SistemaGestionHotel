<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_departamento')->unsigned();
            $table->integer('id_provincia')->unsigned();
            $table->integer('id_distrito')->unsigned();
            $table->string('apellidos_nombre',100)->unique();
            $table->string('tipo_documento',20)->nullable();
            $table->string('numero_documento',10)->nullable();
            $table->string('direccion',70)->nullable();
            $table->string('sexo',20)->nullable();
            $table->string('celular',10)->nullable();
            $table->string('email',50)->nullable();

            $table->foreign('id_departamento')->references('id')->on('departamentos');
            $table->foreign('id_provincia')->references('id')->on('provincias');
            $table->foreign('id_distrito')->references('id')->on('distritos');

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
        Schema::dropIfExists('personas');
    }
}
