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
            $table->string('apellidos_nombre',100)->unique();
            $table->string('tipo_documento',20)->nullable();
            $table->string('numero_documento',10)->nullable();
            $table->string('departamento',50);
            $table->string('provincia',50);
            $table->string('distrito',50);
            $table->string('direccion',70)->nullable();
            $table->string('sexo',20)->nullable();
            $table->string('celular',10)->nullable();
            $table->string('email',50)->nullable();
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
