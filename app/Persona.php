<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $fillable = ['apellidos_nombre','tipo_documento','numero_documento','departamento',
    'provincia','distrito','sexo','celular','email'];

    public function cliente(){
        return $this->hasOne('App\Cliente');
    }
}
