<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable =[
        'idsubcategoria','codigo','nombre','precio_venta','stock','descripcion','condicion'
    ];
    public function subcategoria(){
        return $this->belongsTo('App\Subcategoria');
    }
}
