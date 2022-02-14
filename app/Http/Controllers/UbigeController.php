<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Departamento;
use App\Provincia;
use App\Distrito;

class UbigeController extends Controller
{
    public function selectDepartamento(Request $request){
        if (!$request->ajax()) return redirect('/');
        // $departamentos = Departamento::where('condicion','=','1')
        // ->select('id','nombre')->orderBy('nombre', 'asc')->get();
        // return ['subcategorias' => $subcategorias];

        $departamentos = Departamento::select('id','departamento')
        ->orderBy('departamento','asc')->get();
        return ['departamentos'=>$departamentos];
    }

    public function SelectProvincia(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $provincias = Provincia::where('id_departamento',$request->id_departamento)
                                ->select('id','provincia')->get();
        return ['provincias'=>$provincias];
    }

    public function SelectDistrito(Request $request){
        if (!$request->ajax()) return redirect('/');
        $distritos = Distrito::where('id_provincia',$request->id_provincia)
                             ->select('id','distrito')->get();
        return ['distritos'=>$distritos];
    }
}
