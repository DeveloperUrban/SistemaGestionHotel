<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    protected $table='provincias';
    protected $fillable=['id','id_departamento','provincia'];

    public function Departamento(){
        return $this->belongsTo('App\Departamento');
    } 

    public function Distrito()
    {
        return $this->hasMany('App\Distrito');
    }
}
