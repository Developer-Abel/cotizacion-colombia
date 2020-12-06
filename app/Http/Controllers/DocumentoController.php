<?php

namespace App\Http\Controllers;
use App\models\Documento;
use App\models\Documento_detalle;
use App\models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class DocumentoController extends Controller
{
    public function __construct(){
    }

    function index(){
            $user=Auth()->user();
            $documentos = Documento::select('documento_detalle.documento_id', 'documento_detalle.cantidad','documento_detalle.descripcion','documento_detalle.val_unitario','documento_detalle.val_total')
                ->join('documento_detalle', 'documentos.id_documento', '=', 'documento_detalle.documento_id')
                ->where('documentos.empresa_id',$user->empresa_id)
                ->get();
            return $documentos;
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
