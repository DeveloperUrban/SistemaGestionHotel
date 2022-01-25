<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Recepcion;

class RecepcionController extends Controller
{
    public function index(Request $request){
        // if(!$request->ajax()) return redirect('/');
 
         // $habitaciones = Habitacion::all();
         // return $habitaciones;
 
         $buscar = $request->buscar;
         $criterio = $request->criterio;
 
         if($buscar=='')
         {
             $recepciones = Recepcion::join('habitaciones','recepciones.id_habitacion','=','habitaciones.id')
             ->join('personas','recepciones.id_cliente','=','personas.id')
             ->select('personas.id','personas.apellidos_nombre','personas.numero_documento','habitaciones.numero','habitaciones.detalle','habitaciones.precio',
              'recepciones.numero_noches','recepciones.total_recepcion','recepciones.tipo_pago','recepciones.fecha_ingreso',
              'recepciones.fecha_salida','recepciones.numero_adultos','recepciones.numero_ninos','recepciones.estado'
              )
            ->orderBy('recepciones.id','desc')->paginate(10);
         }
         else{
            $recepciones = Recepcion::join('habitaciones','recepciones.id_habitacion','=','habitaciones.id')
            ->join('personas','recepciones.id_cliente','=','personas.id')
            ->select('personas.id','personas.apellidos_nombre','personas.numero_documento','habitaciones.detalle','habitaciones.precio',
             'recepciones.numero_noches','recepciones.total_recepcion','recepciones.tipo_pago','recepciones.fecha_ingreso',
             'recepciones.fecha_salida','recepciones.numero_adultos','recepciones.numero_ninos','recepciones.estado'
             )
           ->where('personas.'.$criterio,'like','%'.$buscar.'%')   
           ->orderBy('recepciones.id','desc')->paginate(10);
         }
 
         return [
             'pagination'=>[
                 'total'        =>$recepciones->total(),
                 'current_page' =>$recepciones->currentPage(),
                 'per_page'     => $recepciones->perPage(),
                 'last_page'    =>$recepciones->lastPage(),
                 'from'         =>$recepciones->firstItem(),
                 'to'           =>$recepciones->lastItem(),
 
             ],
             'recepciones' =>$recepciones
         ];
     }
 
     public function store(Request $request){
         //if (!$request->ajax()) return redirect('/');
         $recepcion = new Recepcion();
         $recepcion->id_habitacion=$request->id_habitacion;
         $recepcion->id_cliente=$request->id_cliente;
         $recepcion->fecha_ingreso=$request->fecha_ingreso;
         $recepcion->fecha_salida=$request->fecha_salida;
         $recepcion->numero_noches=$request->numero_noches;
         $recepcion->total_recepcion=$request->total_recepcion;
         $recepcion->tipo_pago=$request->tipo_pago;
         $recepcion->numero_adultos=$request->numero_adultos;
         $recepcion->numero_ninos=$request->numero_ninos;
         $recepcion->estado='Registrado';

         $recepcion->save();
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
