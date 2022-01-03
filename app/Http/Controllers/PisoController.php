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
        $pisos = Piso::paginate(8);
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
    public function destroy($id)
    {
        $piso = Piso::findOrFail($id);
        $piso->delete();
    }
}
