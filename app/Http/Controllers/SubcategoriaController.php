<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subcategoria;

class SubcategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Me permite hacer meter un poco de seguridad de las http y redireccionados a la principal
        if (!$request->ajax()) return redirect('/');
        //     $categorias = Categoria::all();
        //     return $categorias;
    
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if ($buscar==''){
            $subcategorias = Subcategoria::orderBy('id', 'desc')->paginate(3);
            // dd($categorias);
            echo($buscar);
        }
        else{
            $subcategorias = Subcategoria::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(3);
        }
        

        return [
            'pagination' => [
                'total'        => $subcategorias->total(),
                'current_page' => $subcategorias->currentPage(),
                'per_page'     => $subcategorias->perPage(),
                'last_page'    => $subcategorias->lastPage(),
                'from'         => $subcategorias->firstItem(),
                'to'           => $subcategorias->lastItem(),
            ],
            'subcategorias' => $subcategorias
        ];
    }

    public function selectSubcategoria(Request $request){
        if (!$request->ajax()) return redirect('/');
        $subcategorias = Subcategoria::where('condicion','=','1')
        ->select('id','nombre')->orderBy('nombre', 'asc')->get();
        return ['subcategorias' => $subcategorias];
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $subcategoria = new Subcategoria();
        $subcategoria -> nombre = $request->nombre;
        $subcategoria->descripcion=$request->descripcion;
        $subcategoria->condicion='1';
        $subcategoria->save();
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
        $subcategoria = Subcategoria::findOrFail($request->id);
        $subcategoria->nombre = $request->nombre;
        $subcategoria->descripcion = $request->descripcion;
        $subcategoria->condicion = '1';
        $subcategoria->save();
    }

    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $subcategoria = Subcategoria::findOrFail($request->id);
        $subcategoria -> condicion='0';
        $subcategoria -> save();
    }

    public function activar(Request $request){
       if(!$request->ajax()) return redirect ('/');
        $subcategoria = Subcategoria::findOrFail($request->id);
        $subcategoria -> condicion ='1';
        $subcategoria->save();
    }
}
