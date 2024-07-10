<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;

class AjedrezIAController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function elegir(){
    	$usuario=DB::table('users')->where('id',Auth::id())->get();
        $nombre=$usuario[0]->name;
        $id=$usuario[0]->id;
    	return view('ajedrezIA',['nombre'=>$nombre,'id'=>$id,'Juego'=>'Ajedrez']);
    }
}