<?php

namespace App\Http\Controllers;
// use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Piso;

class PisoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    //    $piso = Piso::all();
    //     return $piso;
        //Utilizando query builder
        // $piso = DB::table('pisos')->paginate(8);
        // return $piso;
    //Ahora se hará la consulta usando eloquent
    if (!$request->ajax()) return redirect('/');
        $pisos = Piso::paginate(5);
        return [
            'pagination'=>[
                'total'          =>$pisos->total(),
                'current_page'   =>$pisos->currentPage(),
                'per_page'       =>$pisos->perPage(),
                'last_page'      =>$pisos->lastPage(),
                'from'           =>$pisos->firstItem(),
                'to'             =>$pisos->lastItem(),
            ],
            'pisos'=>$pisos
        ];
    }

    public function selectPiso(Request $request){
        if (!$request->ajax()) return redirect('/');
        // $categorias = Categoria::where('condicion','=','1')
        // ->select('id','nombre')->orderBy('nombre', 'asc')->get();
        // return ['categorias' => $categorias];
        $pisos = Piso::select('id','nombre')->orderBy('nombre','asc')->get();
        return ['pisos'=>$pisos];
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $piso = new  Piso();
        $piso->nombre=$request->nombre;
        $piso->descripcion =$request->descripcion;
        $piso->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
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
    public function destroy($id)
    {
        if (!$request->ajax()) return redirect('/');
        $piso = Piso::findOrFail($id);
        $piso->delete();
    }
}
