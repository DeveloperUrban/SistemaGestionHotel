<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;

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
             $clientes = Cliente::join('personas','clientes.id','=','personas.id')
                        ->select('personas.id','personas.apellidos_nombre','personas.tipo_documento',
                        'personas.numero_documento','personas.departamento','personas.provincia','personas.distrito',
                        'personas.sexo','personas.celular','personas.email','clientes.ruc','clientes.nombre_empresa',
                        'clientes.motivo_hospedaje')
                        ->orderBy('personas.id','desc')->paginate(10);
         }
         else{
            $clientes = Cliente::join('personas','clientes.id','=','personas.id')
            ->select('personas.id','personas.apellidos_nombre','personas.tipo_documento',
            'personas.numero_documento','personas.departamento','personas.provincia','personas.distrito',
            'personas.sexo','personas.celular','personas.email','clientes.ruc','clientes.nombre_empresa',
            'clientes.motivo_hospedaje')
            ->where('personas.'.$criterio,'like','%'.$buscar.'%')
            ->orderBy('personas.id','desc')->paginate(10);
         }
 
         return [
             'pagination'=>[
                 'total'        =>$clientes->total(),
                 'current_page' =>$clientes->currentPage(),
                 'per_page'     => $clientes->perPage(),
                 'last_page'    =>$clientes->lastPage(),
                 'from'         =>$clientes->firstItem(),
                 'to'           =>$clientes->lastItem(),
 
             ],
             'clientes' =>$clientes
         ];
     }

     public function store(Request $request){
        $clientes = new Cliente();
        $clientes->id = $request->id;
        $clientes->apellidos_nombre=$request->apellidos_nombre;
        $clientes->tipo_documento=$request->tipo_documento;
        $clientes->departamento=$request->departamento;
        $clientes->provincias=$request->provincias;
        $clientes->distrito=$request->distrito;
        $clientes->sexo=$request->sexo;
        $clientes->celular=$request->celular;
        $clientes->email=$request->email;
        $clientes->ruc=$request->ruc;
        $clientes->nombre_empresa=$request->nombre_empresa;
        $clientes->motivo_hospedaje=$request->motivo_hospedaje;
        $clientes->save();
     }
}
