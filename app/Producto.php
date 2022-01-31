<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table ='productos';  //ya no definimos por que seguimos las reglas de laravel
    protected $primaryKey = 'id';
    protected $fillable =[
        'idcategoria','idsubcategoria','codigo','nombre','precio_venta','stock','descripcion','condicion'
    ];
    public function categoria(){
        return $this->belongsTo('App\Categoria');
    }
    public function subcategoria(){
        return $this->belongsTo('App\Subcategoria');
    }

    public function DetalleVentas()
    {
        return $this->hasMany('App\DetalleVenta');
    }
}
