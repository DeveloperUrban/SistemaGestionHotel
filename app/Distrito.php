<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distrito extends Model
{
    protected $table='distritos';
    protected $fillable=['id','id_provincia','distrito'];

    public function Provincia(){
        return $this->belongsTo('App\Provincia');
    } 
}
