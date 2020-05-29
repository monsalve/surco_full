<?php

namespace App\Http\Controllers\API;

use App\Evaluacion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EvaluacionController extends Controller
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
        return Evaluacion::latest()->paginate(5);
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
            'evaluacion' => 'required|string|max:450'
            , 'id_modulo' => 'required|integer|max:11'
        ]);

        return Evaluacion::create([
            'evaluacion' => $request['evaluacion']
            , 'id_modulo' => $request['id_modulo']
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
        $evaluacion = Evaluacion::findOrFail($id);
        
        $this->validate($request,[
            'evaluacion' => 'required|string|max:450'
            , 'id_modulo' => 'required|integer|max:11'
        ]);

        $evaluacion->update($request->all());
        return ['message' => 'Evaluación actualizada'];
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

        $evaluacion = Evaluacion::findOrFail($id);
        
        $evaluacion->delete();

        return ['message' => 'Evaluación eliminada'];
    }

    public function search ()
    {
        if ($search = \Request::get('q')) {
            $evaluaciones = Evaluacion::where(function ($query) use ($search) {
                $query->where('evaluacion', 'LIKE', "%$search%");
            })->paginate(20);
        } else {
            $evaluaciones = Evaluacion::latest()->paginate(5);
        }

        return $evaluaciones;
    }
}
