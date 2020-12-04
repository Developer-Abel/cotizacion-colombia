<?php

namespace App\Http\Controllers;
use App\models\ItemSencillo;
use App\models\DetalleAcabado;
use Illuminate\Http\Request;
// use App\Http\Controllers\DB;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Str;

class ItemController extends Controller
{
    public function __construct(){
    }

    function index(){
      $documentos =
    }
    function crear(Request $request){
      if ($request->isJson()) {
         $item = new ItemSencillo;
         $item->Cantidad = $request->Cantidad;
         $item->Descripcion = $request->Descripcion;
         $item->TamanoH = $request->TamanoH;
         $isSave = $item->save();

         // $actualizar = ItemSencillo::where('IdItema', 67)
         // ->update([
         //    'cantidad' => 100,
         // ]);
      }else{
         return response()->json(['ERROR'=>'FORMATO NO AUTORIZADO'],401);
      }
    }
}

