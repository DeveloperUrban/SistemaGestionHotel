<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Persona;
use App\Cliente;

class ClienteController extends Controller
{
    public function index(Request $request){
        if(!$request->ajax()) return redirect('/');
 
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

     public function selectCliente(Request $request){
        if (!$request->ajax()) return redirect('/');
        $filtro = $request->filtro;
        $clientes = Persona::where('apellidos_nombre', 'like', '%'. $filtro . '%')
        ->orWhere('numero_documento', 'like', '%'. $filtro . '%')
        ->select('id','apellidos_nombre','numero_documento','tipo_documento','email')
        ->orderBy('apellidos_nombre', 'asc')->get();

        return ['clientes' => $clientes];
     }

     public function store(Request $request){

        if(!$request->ajax()) return redirect('/');
        try {
            DB::beginTransaction();
            $persona = new Persona();
            $persona->id_departamento=$request->id_departamento;
            $persona->id_provincia=$request->id_provincia;
            $persona->id_distrito=$request->id_distrito;
            $persona->apellidos_nombre=strtoupper($request->apellidos_nombre);
            $persona->tipo_documento=$request->tipo_documento;
            $persona->numero_documento=$request->numero_documento;
            $persona->direccion=$request->direccion;
            $persona->sexo=$request->sexo;
            $persona->celular=$request->celular;
            $persona->email=$request->email;
            $persona->save();

            $cliente = new Cliente();
            $cliente->nombre_empresa=$request->nombre_empresa;
            $cliente->motivo_hospedaje=$request->motivo_hospedaje;
            $cliente->id=$persona->id;
            $cliente->save();

            DB::commit();

        } catch (Throwable $th) {
            DB::rollBack();
        }
      
        
     }

     public function update(Request $request){
        if(!$request->ajax()) return redirect('/');
        try {
            DB::beginTransaction();

            //Buscar primero el cliente a modificar
            $cliente = Cliente::findOrFail($request->id);

            $persona = Persona::findOrFail($cliente->id);
            $persona->id_departamento=$request->id_departamento;
            $persona->id_provincia=$request->id_provincia;
            $persona->id_distrito=$request->id_distrito;
            $persona->apellidos_nombre=$request->apellidos_nombre;
            $persona->tipo_documento=$request->tipo_documento;
            $persona->numero_documento=$request->numero_documento;
            $persona->direccion=$request->direccion;
            $persona->sexo=$request->sexo;
            $persona->celular=$request->celular;
            $persona->email=$request->email;
            $persona->save();

            $cliente->nombre_empresa=$request->nombre_empresa;
            $cliente->motivo_hospedaje=$request->motivo_hospedaje;
            $cliente->id=$persona->id;
            $cliente->save();
            
            DB::commit();
            

        } catch (Throwable $th) {
            DB::rollBack();
        }
     }
}
