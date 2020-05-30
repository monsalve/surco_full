<?php

namespace App\Http\Controllers\API;

use App\Documento;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DocumentoController extends Controller
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
        return Documento::latest()->paginate(5);
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
            'nombre' => 'required|max:450'
            , 'ruta' => 'required|max:450'
        ]);

        return Documento::create([
            'nombre' => $request['nombre']
            , 'ruta' => $request['ruta']
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
        $documento = Documento::findOrFail($id);

        $this->validate($request,[
            'nombre' => 'required|max:450'
            , 'ruta' => 'required|max:450'
        ]);

        $documento->update($request->all());
        return ['message' => 'Documento actualizado'];
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

        $documento = Documento::findOrFail($id);
        
        $documento->delete();

        return ['message' => 'Documento eliminado'];
    }

    public function search ()
    {
        if ($search = \Request::get('q')) {
            $documentos = Documento::where(function ($query) use ($search) {
                $query->where('documento', 'LIKE', "%$search%");
            })->paginate(20);
        } else {
            $documentos = Documento::latest()->paginate(5);
        }

        return $documentos;
    }

    public function getDocumentos ($id)
    {
        
        $documentos = Documento::where(function ($query) use ($id) {
            $query->where('id_modulo', 'LIKE', "%$id%");
        })->paginate(80);
       

        return $documentos;
    }
}
