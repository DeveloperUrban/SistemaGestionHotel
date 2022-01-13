<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Departamento;
use App\Provincia;
use App\Distrito;

class UbigeController extends Controller
{
    public function selectDepartamento(Request $request){
        //if (!$request->ajax()) return redirect('/');
        // $departamentos = Departamento::where('condicion','=','1')
        // ->select('id','nombre')->orderBy('nombre', 'asc')->get();
        // return ['subcategorias' => $subcategorias];

        $departamentos = Departamento::select('id','departamento')
        ->orderBy('departamento','asc')->get();
        return ['departamentos'=>$departamentos];
    }

    public function SelectProvincia(Request $request)
    {
        $provincias = Provincia::select('id','provincia')
        ->where('id_departamento','=','1')
        ->orderBy('provincia','asc')->get();

        return ['provincias'=>$provincias];
    }

    public function SelectDistrito(Request $request){
        $distritos = Distrito::select('id','distrito')
        ->where('id_provincia','=','128')
        ->orderBy('distrito','asc')->get();

        return ['distritos'=>$distritos];
    }
}
