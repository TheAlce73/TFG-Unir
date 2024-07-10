<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $usuario=DB::table('users')->where('id',Auth::id())->get();
        $nombre=$usuario[0]->name;
        $id=$usuario[0]->id;
        if ($usuario[0]->Admin) {
            return view('admin',['nombre'=>$nombre,'id'=>$id]);
        }else{
            return view('user',['nombre'=>$nombre,'id'=>$id]);
        }
        
    }
}
