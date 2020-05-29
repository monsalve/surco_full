<?php

namespace App\Http\Controllers\API;

use App\Modulo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ModuloController extends Controller
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
        return Modulo::latest()->paginate(5);
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
            'id_curso' => 'required|integer|max:11'
            , 'contenido' => 'required|string'
            , 'modulo' => 'required|string|max:450'
        ]);

        return Modulo::create([
            'id_curso' => $request['id_curso'] 
            , 'contenido' => $request['contenido'] 
            , 'modulo' => $request['modulo'] 
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
        $modulo = Modulo::findOrFail($id);
        
        $this->validate($request,[
            'id_curso' => 'required|integer|max:11'
            , 'contenido' => 'required|string'
            , 'modulo' => 'required|string|max:450'
        ]);

        $modulo->update($request->all());
        return ['message' => 'Módulo actualizado'];
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

        $modulo = Modulo::findOrFail($id);

        $modulo->delete();

        return ['message' => 'Módulo eliminado'];
    }

    public function search()
    {
        if ($search = \Request::get('q')) {
            $modulo = Modulo::where(function($query) use ($search){
                $query->where('contenido','LIKE',"%$search%")
                        ->orWhere('modulo','LIKE',"%$search%");
            })->paginate(20);
        }else{
            $modulo = Modulo::latest()->paginate(5);
        }

        return $modulo;
    }
}
