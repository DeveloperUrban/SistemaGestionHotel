<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table='clientes';
    protected $fillable = ['id','nombre_empresa','motivo_hospedaje'];

    public $timestamps=false;

    public function persona(){
        return $this->belongsTo('App\Persona');
    }

}
