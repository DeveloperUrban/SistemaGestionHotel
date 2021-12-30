<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Piso;

class PisoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $piso = Piso::all();
        return $piso;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $piso = new  Piso();
        $piso->nombre=$request->nombre;
        $piso->descripcion =$request->descripcion;
        $piso->save();
    }

    public function update(Request $request)
    {
        $piso = Piso::findOrFail($request->id);
        $piso->nombre=$request->nombre;
        $piso->descripcion=$request->descripcion;
        $piso->save();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $piso = Piso::findOrFail($request->id);
        $piso->delete();
    }
}
