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
                     'productos.stock','productos.descripcion','productos.condicion')
                     ->orderBy('productos.id','desc')->paginate(10);
         }
         else{
            $productos = Producto::join('categorias','productos.idcategoria','=','categorias.id')
             ->join('subcategorias','productos.idsubcategoria','=','subcategorias.id')
             ->select('productos.id','productos.idcategoria','categorias.nombre as nombre_categoria','productos.idsubcategoria',
                     'subcategorias.nombre as nombre_subcategoria','productos.codigo','productos.nombre','productos.precio_venta',
                     'productos.stock','productos.descripcion','productos.condicion')
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
     
     public function listarProductoVenta(Request $request)
     {
         //if (!$request->ajax()) return redirect('/');
 
         $buscar = $request->buscar;
         $criterio = $request->criterio;
         
         if ($buscar==''){
             $productos = Producto::join('categorias','productos.idcategoria','=','categorias.id')
             ->select('productos.id','productos.idcategoria','productos.codigo','productos.nombre','categorias.nombre as nombre_categoria','productos.precio_venta','productos.stock','productos.descripcion','productos.condicion')
             ->where('productos.stock','>','0')
             ->orderBy('productos.id', 'desc')->paginate(10);
         }
         else{
             $productos = Producto::join('categorias','productos.idcategoria','=','categorias.id')
             ->select('productos.id','productos.idcategoria','productos.codigo','productos.nombre','categorias.nombre as nombre_categoria','productos.precio_venta','productos.stock','productos.descripcion','productos.condicion')
             ->where('productos.'.$criterio, 'like', '%'. $buscar . '%')
             ->where('productos.stock','>','0')
             ->orderBy('productos.id', 'desc')->paginate(10);
         }
         
 
         return ['productos' => $productos];
     }

    public function buscarProductoVenta(Request $request){
        // if(!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $productos = Producto::where('codigo','=',$filtro)
        ->select('id','nombre','stock','precio_venta')
        ->where('stock','>','0')
        ->orderBy('nombre','asc')
        ->take(1)->get();

        return ['productos'=>$productos];
    }
      
     public function store(Request $request){
         //if (!$request->ajax()) return redirect('/');
         $producto = new Producto();
         $producto->idcategoria = $request->idcategoria;
         $producto->idsubcategoria = $request->idsubcategoria;
         $producto->codigo = $request->codigo;
         $producto->nombre = $request->nombre;
         $producto->precio_venta = $request->precio_venta;
         $producto->stock=$request->stock;
         $producto->descripcion = $request->descripcion;
         $producto->condicion = '1';
         $producto->save();
     }
 
     public function update(Request $request)
     {
         //if (!$request->ajax()) return redirect('/');
         $producto = Producto::findOrFail($request->id);
         $producto->idcategoria = $request->idcategoria;
         $producto->idsubcategoria = $request->idsubcategoria;
         $producto->codigo = $request->codigo;
         $producto->nombre = $request->nombre;
         $producto->precio_venta = $request->precio_venta;
         $producto->stock=$request->stock;
         $producto->descripcion = $request->descripcion;
         $producto->condicion = '1';
         $producto->save();
     }
 
     public function activar(Request $request){
         //if (!$request->ajax()) return redirect('/');
         $producto = Producto::findOrFail($request->id);
         $producto->condicion='1';
         $producto->save();
     }
 
     public function desactivar(Request $request)
     {
         //if (!$request->ajax()) return redirect('/');
         $producto = Producto::findOrFail($request->id);
         $producto->condicion='0';
         $producto->save();
     }
}
