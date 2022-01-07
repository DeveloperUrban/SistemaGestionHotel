<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Piso extends Model
{
     //protected $Piso = 'pisos';  ya no definimos por que seguimos las reglas de laravel
    //protected $primaryKey = 'id';
    protected $fillable = ['nombre','descripcion'];

    public function Habitacion()
    {
        return $this->hasMany('App\Habitacion');
    }

}
