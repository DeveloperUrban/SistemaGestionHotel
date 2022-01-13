<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table='departamentos';
    protected $fillable=['id','departamento'];

    public function Provincia()
    {
        return $this->hasMany('App\Provincia');
    }
    
}
