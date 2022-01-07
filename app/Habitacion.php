<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Habitacion extends Model
{
    protected $table = 'habitaciones';  //ya no definimos por que seguimos las reglas de laravel
    protected $primaryKey = 'id';
    protected $fillable = ['idpiso','idtipohabitacion','numero','detalle','precio','estado'];

    public function Piso()
    {
        return $this->belongsTo('App\Piso');
    }

    public function Tipohabitacion()
    {
        return $this->belongsTo('App\TipoHabitacion');
    }


}
