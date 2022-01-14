<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;

class ClienteController extends Controller
{
    public function index(Request $request){
        // if(!$request->ajax()) return redirect('/');
 
         // $habitaciones = Habitacion::all();
         // return $habitaciones;
         $buscar = $request->buscar;
         $criterio = $request->criterio;
         if($buscar=='')
         {
            $personas =Persona::join('clientes','personas.id','=','clientes.id')
                            ->join('departamentos','personas.id_departamento','=','departamentos.id')
                            ->join('provincias','personas.id_provincia','=','provincias.id')
                            ->join('distritos','personas.id_distrito','=','distritos.id')
                            ->select('personas.id','personas.apellidos_nombre','personas.tipo_documento',
                            'personas.numero_documento','departamentos.id as id_departamento','departamentos.departamento',
                            'provincias.id as id_provincia','provincias.provincia','distritos.id as id_distrito','distritos.distrito',
                            'personas.direccion','personas.sexo','personas.celular','personas.email','clientes.nombre_empresa',
                            'clientes.motivo_hospedaje')
                            ->orderBy('personas.id','desc')->paginate(10);
         }
         else{
            $personas =Persona::join('clientes','personas.id','=','clientes.id')
                            ->join('departamentos','personas.id_departamento','=','departamentos.id')
                            ->join('provincias','personas.id_provincia','=','provincias.id')
                            ->join('distritos','personas.id_distrito','=','distritos.id')
                            ->select('personas.id','personas.apellidos_nombre','personas.tipo_documento',
                            'personas.numero_documento','departamentos.id as id_departamento','departamentos.departamento',
                            'provincias.id as id_provincia','provincias.provincia','distritos.id as id_distrito','distritos.distrito',
                            'personas.direccion','personas.sexo','personas.celular','personas.email','clientes.nombre_empresa',
                            'clientes.motivo_hospedaje')
                            ->where('personas.'.$criterio,'like','%'.$buscar.'%')
                            ->orderBy('personas.id','desc')->paginate(10);
         }
 
         return [
             'pagination'=>[
                 'total'        =>$personas->total(),
                 'current_page' =>$personas->currentPage(),
                 'per_page'     => $personas->perPage(),
                 'last_page'    =>$personas->lastPage(),
                 'from'         =>$personas->firstItem(),
                 'to'           =>$personas->lastItem(),
 
             ],
             'personas' =>$personas
         ];
     }

     public function store(Request $request){
        $personas = new Cliente();
        $personas->id = $request->id;
        $personas->apellidos_nombre=$request->apellidos_nombre;
        $personas->tipo_documento=$request->tipo_documento;
        $personas->departamento=$request->departamento;
        $personas->provincias=$request->provincias;
        $personas->distrito=$request->distrito;
        $personas->sexo=$request->sexo;
        $personas->celular=$request->celular;
        $personas->email=$request->email;
        $personas->ruc=$request->ruc;
        $personas->nombre_empresa=$request->nombre_empresa;
        $personas->motivo_hospedaje=$request->motivo_hospedaje;
        $personas->save();
     }
}
