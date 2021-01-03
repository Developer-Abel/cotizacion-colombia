<?php

namespace App\Http\Controllers;
use App\models\Empresa;
use App\models\Documento;
use App\models\Documento_detalle;
use App\models\ItemSencillo;
use App\models\DetalleAcabado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

// prueba
use Illuminate\Support\Facades\DB;


class DocumentoController extends Controller
{
    public function __construct(){
    }

   function index(){
      $user=Auth()->user();
      $documentos = Documento::select('documento_detalle.id_detalle','documento_detalle.documento_id', 'documento_detalle.cantidad','documento_detalle.descripcion','documento_detalle.val_unitario','documento_detalle.val_total')
          ->join('documento_detalle', 'documentos.id_documento', '=', 'documento_detalle.documento_id')
          ->where('documentos.empresa_id',$user->empresa_id)
          ->get();
      return response()->json($documentos,200);
   }

   function create(Request $request){
      DB::beginTransaction();
      try{
         $user=Auth()->user();
            $id_documento;
            if ($request->id_documento == 0) {
               $documento = new Documento;
               $documento->empresa_id   = $user->empresa_id;
               $documento->tercero_id   = $request->id_tercero;
               $documento->no_documento = '000';
               $documento->fecha        = '2020-08-12 00:00:00';
               $documento->subtotal     = '0';
               $documento->descuento    = '0';
               $documento->iva          = '0';
               $documento->total        = '0';
               $documento->observacion  = '';
               $documento->status       = 'BORRADOR';
               $documento->deleted      = '0';
               $documento->save();
               $id_documento = $documento->id_documento;
            }else{
               $id_documento = $request->id_documento;
            }
            $documento_d = new Documento_detalle;
            $documento_d->documento_id   = $id_documento;
            $documento_d->tipo_documento = $request->tipo_documento;
            $documento_d->cantidad       = $request->cantidad;
            $documento_d->descripcion    = $request->descripcion;
            $documento_d->val_unitario   = 0.0;
            $documento_d->val_total      = 0.0;
            $documento_d->deleted        = 0;
            $documento_d->save();
               $item = new ItemSencillo;
               $item->detalle_id       = $documento_d->id_detalle;
               $item->tamano_v         = "";
               $item->cant_montaje     = 0;
               $item->corte_papel_h    = "";
               $item->corte_papel_y    = "";
               $item->num_tinta_tiro   = "";
               $item->num_tinta_retiro = "";
               $item->vr_diseno        = $request->val_diseno;
               $item->vr_trasporte     = $request->transporte;
               $item->vr_rifle         = $request->val_rifle;
               $item->inicio_num       = "";
               $item->TamanoH          = $request->tam_1." ".$request->tam_2;
               $item->save();
               if ($request->hayAcabado) {
                  for ($i=1; $i < 10; $i++) {
                     $detalleAcabado = new DetalleAcabado;
                     if ($request->{"num_acabado$i"} == true) {
                        $detalleAcabado->detalle_id= $documento_d->id_detalle;
                        $detalleAcabado->acabado_id = $i;
                        $detalleAcabado->save();
                     }
                  }
               }
         DB::commit();
         return response()->json($id_documento ,200);
      }catch (\Exception $e){
         DB::rollback();
         return response()->json($e,400);
      }
   }

   function edit(Request $request){
      $documentos = Documento::select("documentos.id_documento", "documento_detalle.cantidad", "documento_detalle.descripcion", "documento_detalle.val_unitario","itemsencillos.vr_diseno","itemsencillos.vr_diseno", "itemsencillos.vr_rifle")
          ->join('documento_detalle', 'documentos.id_documento', '=', 'documento_detalle.documento_id')
          ->join('itemsencillos', 'itemsencillos.detalle_id', '=', 'documento_detalle.id_detalle')
          ->where('documentos.id_documento',$request->id_documento)
          ->where('documento_detalle.id_detalle',$request->id_detalle)
          ->get();
      return response()->json($documentos,200);
   }
}





