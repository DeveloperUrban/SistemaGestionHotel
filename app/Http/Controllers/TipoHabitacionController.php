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
    public function index(Request $request)
    {
        // $tipos = Tipohabitacion::all();
        // return $tipos;
       if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $tipohabitacion = Tipohabitacion::orderBy('id', 'desc')->paginate(3);
        }
        else{
            $tipohabitacion = Tipohabitacion::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(3);
        }
        

        return [
            'pagination' => [
                'total'        => $tipohabitacion->total(),
                'current_page' => $tipohabitacion->currentPage(),
                'per_page'     => $tipohabitacion->perPage(),
                'last_page'    => $tipohabitacion->lastPage(),
                'from'         => $tipohabitacion->firstItem(),
                'to'           => $tipohabitacion->lastItem(),
            ],
            'tipohabitaciones' => $tipohabitacion
        ];
    }

    public function selectTipohabitacion(Request $request){
        if (!$request->ajax()) return redirect('/');
        // $categorias = Categoria::where('condicion','=','1')
        // ->select('id','nombre')->orderBy('nombre', 'asc')->get();
        // return ['categorias' => $categorias];
        $tipohabitaciones = Tipohabitacion::where('condicion','=','1')
                            ->select('id','nombre')->orderBy('nombre','asc')->get();
                            return ['tipohabitaciones'=>$tipohabitaciones];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
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
        if (!$request->ajax()) return redirect('/');
        $tipohabitacion = Tipohabitacion::findOrFail($request->id);
        $tipohabitacion->nombre=$request->nombre;
        $tipohabitacion->descripcion=$request->descripcion;
        $tipohabitacion->condicion='1';
        $tipohabitacion->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $tipohabitacion = Tipohabitacion::findOrFail($request->id);
        $tipohabitacion->condicion = '1';
        $tipohabitacion->save();
    }

    public function desactivar(Request $request){
                
        if (!$request->ajax()) return redirect('/');
        $tipohabitacion = Tipohabitacion::findOrFail($request->id);
        $tipohabitacion->condicion = '0';
        $tipohabitacion->save();
    }

}
