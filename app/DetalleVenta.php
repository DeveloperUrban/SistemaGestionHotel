<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $table = 'detalle_ventas';
    protected $fillable =[
        'id_venta',
        'id_producto',
        'cantidad',
        'precio',
        'descuento'
    ];

    public $timestamps = false;

    public function Venta(){
        return $this->belongsTo('App\Venta');
    }

    public function Producto()
    {
        return $this->belongsTo('App\Producto');
    }
}
