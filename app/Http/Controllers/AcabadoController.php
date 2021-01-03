<?php

namespace App\Http\Controllers;
use App\models\Acabado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;


class AcabadoController extends Controller
{
    public function __construct(){
    }

    function index(){
      $acabado = Acabado::all();
       return response()->json($acabado,200);
    }
}





