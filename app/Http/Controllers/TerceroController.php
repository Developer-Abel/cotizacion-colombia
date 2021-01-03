<?php

namespace App\Http\Controllers;
use App\models\Empresa;
use App\models\Tercero;
use Illuminate\Http\Request;


class TerceroController extends Controller
{
    public function __construct(){
    }

    function index_cli(){
      $user=Auth()->user();
      $cliente = Tercero::select('terceros.*')
          ->join('empresa_tercero', 'empresa_tercero.tercero_id', '=', 'terceros.id_tercero')
          ->where('empresa_tercero.empresa_id',$user->empresa_id)
          ->where('empresa_tercero.tipo','cliente')
          ->get();
       return response()->json([
                'response' => 'success',
                'clientes' => $cliente
            ],200);
    }
    function getCliente(Request $request){
      $user=Auth()->user();
      $cliente = Tercero::select(
        'terceros.id_tercero',
        'terceros.nombre',
        'terceros.telefono',
        'terceros.celular',
        'terceros.email',
        'terceros.calle',
        'terceros.num_int',
        'terceros.num_ext',
        'terceros.barrio',
        'estados.estado',
        'paises.pais'
      )
          ->join('empresa_tercero', 'empresa_tercero.tercero_id', '=', 'terceros.id_tercero')
          ->leftjoin('estados', 'estados.id_estado', '=', 'terceros.estado_id')
          ->leftjoin('paises', 'paises.id_pais', '=', 'estados.pais_id')
          ->where('empresa_tercero.empresa_id',$user->empresa_id)
          ->where('empresa_tercero.tipo','cliente')
          ->where('empresa_tercero.num_key',$request->num_key)
          ->first();

          if ($cliente == null) {
            return response()->json( "Cliente no encontrado",401);
          }
       return response()->json( $cliente,200);
    }

    function registrer(Request $request){
        // $user = new User;
        // $user->nombre = $request->nombre;
        // $user->apellido_p = $request->apellido_p;
        // $user->apellido_m = $request->apellido_m;
        // $user->usuario = $request->usuario;
        // $user->email = $request->email;
        // $user->password = Hash::make($request->password);
        // $user->empresa_id = $request->empresa_id;
        // $user->cedula = $request->cedula;
        // $user->cargo = $request->cargo;
        // $user->telefono = $request->telefono;
        // $user->celular = $request->celular;
        // $user->deleted = 0;

        // if ($user->save()) {
        //     return response()->json([
        //         'response' => 'usuario creado correctamente',
        //         'usuario' => $user
        //     ],201);
        // }
        // return response()->json([
        //         'response' => 'error al registrar al usuario'
        //     ],404);
    }



}
