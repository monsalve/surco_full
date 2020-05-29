<?php

namespace App\Http\Controllers\API;

use App\Resultado;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResultadoController extends Controller
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
        // $this->authorize('isAdmin');
        //if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor')) {
        return Resultado::latest()->paginate(5);
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
            'id_alumno'         => 'required|integer'
            , 'id_curso'        => 'required|integer'
            , 'id_evaluacion'   => 'required|integer'
            , 'preguntas'       => 'required|integer'
            , 'respondidas'     => 'required|integer'
            , 'resultado'       => 'required|integer'
            , 'estado_eva'      => 'required|integer'
        ]);

        return Resultado::create([
            'id_alumno'         => $request['id_alumno']
            , 'id_curso'        => $request['id_curso']
            , 'id_evaluacion'   => $request['id_evaluacion']
            , 'preguntas'       => $request['preguntas']
            , 'respondidas'     => $request['respondidas']
            , 'resultado'       => $request['resultado']
            , 'estado_eva'      => $request['estado_eva']
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
        $resultado = Resultado::findOrFail($id);

        $this->validate($request,[
            'id_alumno'         => 'required|integer'
            , 'id_curso'        => 'required|integer'
            , 'id_evaluacion'   => 'required|integer'
            , 'preguntas'       => 'required|integer'
            , 'respondidas'     => 'required|integer'
            , 'resultado'       => 'required|integer'
            , 'estado_eva'      => 'required|integer'
        ]);

        $resultado->update($request->all());
        return ['message' => 'Resultado actualizado'];
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

        $resultado = Resultado::findOrFail($id);

        $resultado->delete();

        return ['message' => 'Resultado eliminado'];
    }

    public function search()
    {
        if ($search = \Request::get('q')) {
            $resultados = Resultado::where(function($query) use ($search){
                $query->where('id_alumno','=', $search);
            })->paginate(20);
        }else{
            $resultados = Resultado::latest()->paginate(5);
        }

        return $resultados;
    }
}
