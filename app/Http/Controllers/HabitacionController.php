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
            ->where('habibtaciones.'.$criterio,'like','%'.$buscar.'%')
            ->orderBy('habitaciones.id','desc')->paginate(3);
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

    public function store(Request $request){

    }

    public function update(Request $request)
    {
        
    }

    public function activar(Request $request){

    }

    public function desactivar(Request $request)
    {

    }
}
