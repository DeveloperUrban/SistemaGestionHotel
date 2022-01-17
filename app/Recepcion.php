<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recepcion extends Model
{
    protected $table='recepciones';
    protected $primaryKey='id';
    protected $fillable = ['id_habitacion','id_cliente','fecha_hora',
                        'fecha_ingreso','fecha_salida','numero_adultos','numero_ninos'];
    
    public function Habitacion(){
        return $this->belongsTo('App\Habitacion');
    }

    public function Persona(){
        return $this->belongsTo('App\Persona');
    }
}
