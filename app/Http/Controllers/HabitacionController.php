<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Habitacion;

class HabitacionController extends Controller
{
    public function index(Request $request){
       // if(!$request->ajax()) return redirect('/');

        // $habitaciones = Habitacion::all();
        // return $habitaciones;

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar=='')
        {
            $habitaciones = Habitacion::join('pisos','habitaciones.idpiso','=','pisos.id')
            ->join('tipohabitaciones','habitaciones.idtipohabitacion','=','tipohabitaciones.id')
            ->select('habitaciones.id','habitaciones.idpiso','habitaciones.idtipohabitacion',
                    'habitaciones.numero','habitaciones.detalle','habitaciones.precio','habitaciones.estado',
                    'pisos.nombre as nombre_piso','tipohabitaciones.nombre as nombre_tipohabitacion')
                    ->orderBy('habitaciones.id','desc')->paginate(10);
        }
        else{
            $habitaciones = Habitacion::join('pisos','habitaciones.idpiso','=','pisos.id')
            ->join('tipohabitaciones','habitaciones.idtipohabitacion','=','tipohabitaciones.id')
            ->select('habitaciones.id','habitaciones.idpiso','habitaciones.idtipohabitacion',
                    'habitaciones.numero','habitaciones.detalle','habitaciones.precio','habitaciones.estado',
                    'pisos.nombre as nombre_piso','tipohabitaciones.nombre as nombre_tipohabitacion')
            ->where('habitaciones.'.$criterio,'like','%'.$buscar.'%')        
            ->orderBy('habitaciones.id','desc')->paginate(10);
        }

        return [
            'pagination'=>[
                'total'        =>$habitaciones->total(),
                'current_page' =>$habitaciones->currentPage(),
                'per_page'     => $habitaciones->perPage(),
                'last_page'    =>$habitaciones->lastPage(),
                'from'         =>$habitaciones->firstItem(),
                'to'           =>$habitaciones->lastItem(),

            ],
            'habitaciones' =>$habitaciones
        ];
    }

    public function ListarHabitacion(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar==''){
            $habitaciones = Habitacion::join('pisos','habitaciones.idpiso','=','pisos.id')
            ->join('tipohabitaciones','habitaciones.idtipohabitacion','=','tipohabitaciones.id')
            ->select('numero','detalle','precio','tipohabitaciones.nombre as tipo_habitacion','pisos.nombre as piso','estado')
            ->orderBy('habitaciones.id','desc')->paginate(3);
        }
        else{
            $habitaciones = Habitacion::join('pisos','habitaciones.idpiso','=','pisos.id')
            ->join('tipohabitaciones','habitaciones.idtipohabitacion','=','tipohabitaciones.id')
            ->select('numero','detalle','precio','tipohabitaciones.nombre as tipo_habitacion','pisos.nombre as piso','estado')
            ->where('habitaciones.'.$criterio,'like','%'.$buscar.'%')
            ->orderBy('habitaciones.id','desc')->paginate(3);
        }
    }
    public function store(Request $request){
        //if (!$request->ajax()) return redirect('/');
        $habitacion = new Habitacion();
        $habitacion->idpiso = $request->idpiso;
        $habitacion->idtipohabitacion = $request->idtipohabitacion;
        $habitacion->numero = $request->numero;
        $habitacion->detalle = $request->detalle;
        $habitacion->precio = $request->precio;
        $habitacion->estado = '1';
        $habitacion->save();
    }

    public function update(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        $habitacion = Habitacion::findOrFail($request->id);
        $habitacion->numero = $request->numero;
        $habitacion->detalle = $request->detalle;
        $habitacion->precio = $request->precio;
        $habitacion->idpiso = $request->idpiso;
        $habitacion->idtipohabitacion = $request->idtipohabitacion;
        $habitacion->estado = '1';
        $habitacion->save();
    }

    public function activar(Request $request){
        //if (!$request->ajax()) return redirect('/');
        $habitacion = Habitacion::findOrFail($request->id);
        $habitacion->estado='1';
        $habitacion->save();
    }

    public function desactivar(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        $habitacion = Habitacion::findOrFail($request->id);
        $habitacion->estado='0';
        $habitacion->save();
    }
}
