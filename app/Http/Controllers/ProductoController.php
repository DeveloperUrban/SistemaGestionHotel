<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;

class ProductoController extends Controller
{
    public function index(Request $request){
        // if(!$request->ajax()) return redirect('/');
 
        //  $productos = Producto::all();
        //  return $productos;
 
         $buscar = $request->buscar;
         $criterio = $request->criterio;
 
         if($buscar=='')
         {
             $productos = Producto::join('categorias','productos.idcategoria','=','categorias.id')
             ->join('subcategorias','productos.idsubcategoria','=','subcategorias.id')
             ->select('productos.id','productos.idcategoria','categorias.nombre as nombre_categoria','productos.idsubcategoria',
                     'subcategorias.nombre as nombre_subcategoria','productos.codigo','productos.nombre','productos.precio_venta',
                     'productos.stock','productos.descripcion','','productos.condicion')
                     ->orderBy('productos.id','desc')->paginate(10);
         }
         else{
            $productos = Producto::join('categorias','productos.idcategoria','=','categorias.id')
            ->join('subcategorias','productos.idsubcategoria','=','subcategorias.id')
            ->select('productos.id','productos.idcategoria','categorias.nombre as nombre_categoria','productos.idsubcategoria',
                    'subcategorias.nombre as nombre_subcategoria','productos.codigo','productos.nombre','productos.precio_venta',
                    'productos.stock','productos.descripcion','','productos.condicion')
             ->where('productos.'.$criterio,'like','%'.$buscar.'%')        
             ->orderBy('productos.id','desc')->paginate(10);
         }
 
         return [
             'pagination'=>[
                 'total'        =>$productos->total(),
                 'current_page' =>$productos->currentPage(),
                 'per_page'     => $productos->perPage(),
                 'last_page'    =>$productos->lastPage(),
                 'from'         =>$productos->firstItem(),
                 'to'           =>$productos->lastItem(),
 
             ],
             'productos' =>$productos
         ];
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
