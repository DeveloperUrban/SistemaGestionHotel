<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
//use Carbon\Carbon;
use App\Venta;
use App\DetalleVenta;
//use App\User;
//use App\Notifications\NotifyAdmin;

class VentaController extends Controller
{
  public function index(Request $request){
    //if(!$request->ajax()) return redirect('/');
    $buscar=$request->buscar;
    $criterio = $request->criterio;

    if($buscar=='')
    {
      $ventas = Venta::join('recepciones','ventas.id_recepcion','=','recepciones.id')
                     //->join('users','ventas.idusuario','=','users.id')
                     ->join('habitaciones','recepciones.id_habitacion','=','habitaciones.id')
                     ->join('personas','recepciones.id_cliente','=','personas.id')
                     ->select('ventas.id','habitaciones.numero as numero_habitacion','personas.apellidos_nombre','ventas.tipo_comprobante','ventas.serie_comprobante',
                              'ventas.num_comprobante','ventas.fecha_hora','ventas.impuesto','ventas.total',
                              'ventas.estado')
                     ->orderBy('ventas.id','desc')->paginate(10);
    }
    else{
        $ventas = Venta::join('recepciones','ventas.id_recepcion','=','recepciones.id')
        //->join('users','ventas.idusuario','=','users.id')
        ->join('habitaciones','recepciones.id_habitacion','=','habitaciones.id')
        ->join('personas','recepciones.id_cliente','=','personas.id')
        ->select('ventas.id','habitaciones.numero as numero_habitacion','personas.apellidos_nombre','ventas.tipo_comprobante','ventas.serie_comprobante',
                 'ventas.num_comprobante','ventas.fecha_hora','ventas.impuesto','ventas.total',
                 'ventas.estado')
        ->where('ventas.'.$criterio,'like','%'.$buscar.'%')
        ->orderBy('ventas.id','desc')->paginate(10);
    }

    return [
        'pagination' =>[
            'total'        =>$ventas->total(),
            'current_page' =>$ventas->currentPage(),
            'per_page'     =>$ventas->perPage(),
            'last_page'    =>$ventas->lastpage(),
            'from'         =>$ventas->firstItem(),
            'to'           =>$ventas->lastItem(),
        ],
        'ventas' => $ventas
    ];


  }  

  public function store(Request $request){
    //if(!$request->ajax()) return redirect('/');
    try {
        DB::beginTransaction();
        $mytime = Carbon::now('America/Lima');
        $venta = new Venta();
        $venta->id_recepcion = $request->id_recepcion;
        $venta->tipo_comprobante = $request->tipo_comprobante;
        $venta->serie_comprobante = $request->serie_comprobante;
        $venta->num_comprobante = $request->num_comprobante;
        $venta->fecha_hora = $mytime->toDateTimeString();
        $venta->impuesto = $request->impuesto;
        $venta->total = $request->total;
        $venta->estado = $request->estado;
        $venta->save();

       
        $detalles = $request->data;  //Array de detalles 
        //Recorro todo los elementos

        foreach ($detalles as $ep => $det) {
            $detalle = new DetalleVenta();
            $detalle->id_venta = $venta->id;
            $detalle->id_producto = $det['idarticulo'];
            $detalle->cantidad =$det['cantidad'];
            $detalle->precio=$det['precio'];
            $detalle->descuento = $det['descuento'];
            $detalle->save();
        }

        DB::commit();

        return [
            'id' => $venta->id
        ];

    } catch (Exception $e) {
        DB::rollBack();
    }
  }

  public function obtenerCabecera(Request $request){
    //if(!$request->ajax()) return redirect('/');
    $id = $request->id;
    $venta = Venta::join('recepciones','ventas.id_recepcion','=','recepciones.id')
                  ->join('personas','recepciones.id_cliente','personas.id')
                  ->select('ventas.id','ventas.tipo_comprobante','ventas.serie_comprobante',
                  'ventas.num_comprobante','ventas.fecha_hora','ventas.impuesto','ventas.total',
                  'ventas.estado','personas.apellidos_nombre')
                  ->where('ventas.id','=',$id)
                  ->orderBy('ventas.id','desc')->take(1)->get();
    return ['venta'=>$venta];
  }

  public function obtenerDetalles(Request $request){
    //if(!$request->ajax()) return redirect('/');

    $id = $request->id;
        $detalles = DetalleVenta::join('productos','detalle_ventas.id_producto','=','productos.id')
        ->select('detalle_ventas.cantidad','detalle_ventas.precio','detalle_ventas.descuento',
        'productos.nombre as producto')
        ->where('detalle_ventas.id_venta','=',$id)
        ->orderBy('detalle_ventas.id', 'desc')->get();
        
        return ['detalles' => $detalles];
  }
  public function desactivar(Request $request){
   // if(!$request->ajax()) return redirect('/');
   $venta=Venta::findOrFail($request->id);
   $venta->estado = 'Cancelado';
   $venta->save();
  }
}
