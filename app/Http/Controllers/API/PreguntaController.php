<?php

namespace App\Http\Controllers\API;

use APP\Pregunta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PreguntaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        //if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor')) {
        return Pregunta::latest()->paginate(5);
        //}
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'id_evaluacion' => 'required|integer|max:11'
            , 'tipo'        => 'required|integer|max:11'
            , 'pregunta'    => 'required|string|'
            , 'a'           => 'required|string|max:450'
            , 'b'           => 'required|string|max:450'
            , 'c'           => 'required|string|max:450'
            , 'd'           => 'required|string|max:450'
            , 'e'           => 'required|string|max:450'
            , 'f'           => 'required|string|max:450'
            , 'respuesta'   => 'required|string|size:1'
        ]);

        return Pregunta::create([
            'id_evaluacion' => $request['id_evaluacion']
            , 'tipo'        => $request['tipo']
            , 'pregunta'    => $request['pregunta']
            , 'a'           => $request['a']
            , 'b'           => $request['b']
            , 'c'           => $request['c']
            , 'd'           => $request['d']
            , 'e'           => $request['e']
            , 'f'           => $request['f']
            , 'respuesta'   => $request['respuesta']
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pregunta = Pregunta::findOrFail($id);
        
        $this->validate($request,[
            'id_evaluacion' => 'required|integer|max:11'
            , 'tipo'        => 'required|integer|max:11'
            , 'pregunta'    => 'required|string|'
            , 'a'           => 'required|string|max:450'
            , 'b'           => 'required|string|max:450'
            , 'c'           => 'required|string|max:450'
            , 'd'           => 'required|string|max:450'
            , 'e'           => 'required|string|max:450'
            , 'f'           => 'required|string|max:450'
            , 'respuesta'   => 'required|string|size:1'
        ]);

        $pregunta->update($request->all());
        return ['message' => 'Pregunta actualizada'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');

        $pregunta = Pregunta::findOrFail($id);

        $pregunta->delete();

        return ['message' => 'Pregunta eliminada'];
    }

    public function search()
    {
        if ($search = \Request::get('q')) {
            $preguntas = Pregunta::where(function($query) use ($search){
                $query->where('pregunta','LIKE',"%$search%");
            })->paginate(20);
        } else {
            $preguntas = Pregunta::latest()->paginate(5);
        }

        return $preguntas;
    }
}
