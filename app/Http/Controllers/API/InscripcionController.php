<?php

namespace App\Http\Controllers\API;

use App\Inscripcion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InscripcionController extends Controller
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
        return Inscripcion::latest()->paginate(5);
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
            'id_alumno'     => 'required|integer|max:11'
            , 'id_curso'    => 'required|integer|max:11'
            , 'fecha'       => 'required|date_format:Y-m-d'
            , 'resultado'   => 'required|numeric'
        ]);

        return Inscripcion::create([
            'id_alumno'     => $request['id_alumno']
            , 'id_curso'    => $request['id_curso']
            , 'fecha'       => $request['fecha']
            , 'resultado'   => $request['resultado']
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
        $inscripcion = Inscripcion::findOrFail($id);
        
        $this->validate($request,[
            'id_alumno'     => 'required|integer|max:11'
            , 'id_curso'    => 'required|integer|max:11'
            , 'fecha'       => 'required|date_format:Y-m-d'
            , 'resultado'   => 'required|numeric'
        ]);

        $inscripcion->update($request->all());
        return ['message' => 'Inscripción actualizada'];
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

        $inscripcion = Inscripcion::findOrFail($id);
        
        $inscripcion->delete();

        return ['message' => 'Inscripción eliminada'];
    }

    public function search ()
    {
        if ($search = \Request::get('q')) {
            $inscripciones = Inscripcion::where(function ($query) use ($search) {
                $query->where('fecha', '=', $search);
            })->paginate(20);
        } else {
            $inscripciones = Inscripcion::latest()->paginate(5);
        }

        return $inscripciones;
    }
}
