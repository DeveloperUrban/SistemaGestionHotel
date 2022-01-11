<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subcategoria extends Model
{
    protected $fillable = ['nombre', 'descripcion', 'condicion'];

    public function Producto()
    {
        return $this->hasMany('App\Producto');
    }
}
