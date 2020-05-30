<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\User;
use App\Categoria;
use App\Curso;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $users = User::where('type','=','author')->orderBy('name', 'asc')->get();
       
        return view('welcome',['users' => $users]);
    }

    public function getListTutoresArray() {
        $tutores = User::where('type','=','author')->select('id','name')->orderBy('name', 'asc')->get();
        $aux_tuts = array();
        foreach($tutores as $tutor){    $aux_tuts[$tutor->id] = $tutor->name; }
        return $aux_tuts;
    }

    public function getListCategorisArray() {
        $categorias = Categoria::select('id','categoria')->orderBy('categoria', 'asc')->get();
        $aux_cats = array();
        foreach($categorias as $categoria){    $aux_cats[$categoria->id] = $categoria->categoria; }
        return $aux_cats;
    }

    public function oferta()
    {               
        $cursos = Curso::where('estado','=',1)->orderBy('nombre', 'asc')->get();

        return view('oferta',[ 'cursos' => $cursos, 'tutores' => $this->getListTutoresArray(), 'categorias' => $this->getListCategorisArray()]);
    }

    public function detalle(Request $request, $id)
    {
        $curso = array();
        $curso= Curso::where('id','=',$id)->orderBy('nombre', 'asc')->get();
        //var_dump($curso); exit; die;
        $user = auth()->user();
        //$data = $request->session()->all();
        
        return view('detalle', ['curso' => $curso[0], 'tutores' => $this->getListTutoresArray(), 'categorias' => $this->getListCategorisArray(), 'user' => $user]);
    }

    public function dashboard(){
        return view('home');
    }
}
