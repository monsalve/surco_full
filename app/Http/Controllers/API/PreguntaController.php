<?php

namespace App\Http\Controllers\API;

use App\Pregunta;
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
            'pregunta' => 'required|max:450'
            , 'respuesta' => 'required|max:450'
        ]);

        return Pregunta::create([
            'pregunta' => $request['pregunta']
            , 'respuesta' => $request['respuesta']
            , 'id_modulo' => $request['id_modulo']
            , 'tipo' => $request['tipo']
            , 'a' => $request['a'], 'b' => $request['b'], 'c' => $request['c'], 'd' => $request['d'], 'e' => $request['e'], 'f' => $request['f']
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
            'pregunta' => 'required|max:450'
            , 'respuesta' => 'required|max:450'
        ]);
        
        $pregunta->update($request->all());
        return ['message' => 'Pregunta actualizado'];
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

        return ['message' => 'Pregunta eliminado'];
    }

    public function search ()
    {
        if ($search = \Request::get('q')) {
            $preguntas = Pregunta::where(function ($query) use ($search) {
                $query->where('pregunta', 'LIKE', "%$search%");
            })->paginate(20);
        } else {
            $preguntas = Pregunta::latest()->paginate(5);
        }

        return $preguntas;
    }

    public function getPreguntas ($id)
    {
        
        $preguntas = Pregunta::where(function ($query) use ($id) {
            $query->where('id_modulo', 'LIKE', "%$id%");
        })->get();
       

        return $preguntas;
    }
}
