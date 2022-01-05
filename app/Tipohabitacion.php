<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipohabitacion extends Model
{
    protected $table = 'tipohabitaciones';  //ya no definimos por que seguimos las reglas de laravel
    protected $primaryKey = 'id';
    protected $fillable = ['nombre','descripcion','condicion'];
}
