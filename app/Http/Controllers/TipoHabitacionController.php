<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tipohabitacion;

class TipohabitacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipos = Tipohabitacion::all();
        return $tipos;
    }

   
    public function store(Request $request)
    {
        $tipohabitacion = new Tipohabitacion();
        $tipohabitacion->nombre=$request->nombre;
        $tipohabitacion->descripcion =$request->descripcion;
        $tipohabitacion->condicion='1';
        $tipohabitacion->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $tipohabitacion = Tipohabitacion::findOrFail($request->id);
        $tipohabitacion->nombre=$request->nombre;
        $tipohabitacion->descripcion=$request->descripcion;
        $tipohabitacion->condicion='1';
        $tipohabitacion->save();
    }

    public function activar(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        $tipohabitacion = Tipohabitacion::findOrFail($request->id);
        $tipohabitacion->condicion = '1';
        $tipohabitacion->save();
    }

    public function desactivar(Request $request){
                
        //if (!$request->ajax()) return redirect('/');
        $tipohabitacion = Tipohabitacion::findOrFail($request->id);
        $tipohabitacion->condicion = '0';
        $tipohabitacion->save();
    }

}
