<?php

namespace Candidatos\Http\Controllers;

use Candidatos\Peticion;
use Illuminate\Http\Request;

class PeticionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $peticiones = Peticion::where('baja', 0)->paginate(10);
         return view('peticiones.index', compact('peticiones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('peticiones.create')->with('editar',1);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $peticion = new Peticion();
        $peticion->name = $request->input('nombre');
        $peticion->contexto = $request->input('contexto');
        $peticion->mail_comercial = $request->input('mail_comercial');
        $peticion->ubicacion = $request->input('ubicacion');
        if ($request->input('presencial')){
            $peticion->presencial = 1;
        } else{
            $peticion->presencial = 0;
        }
        
        $peticion->baja = 0;
        $peticion->save();

        return redirect()->route('peticiones.index')->with('info', 'Petición creada exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $peticion = Peticion::findOrFail($id);

        return view('peticiones.create', compact('peticion'))->with('editar',0);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $peticion = Peticion::findOrFail($id);

        return view('peticiones.create', compact('peticion'))->with('editar',1);
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
        $peticion = Peticion::findOrFail($id);
        $peticion->name = $request->input('nombre');
        $peticion->contexto = $request->input('contexto');
        $peticion->mail_comercial = $request->input('mail_comercial');
        $peticion->ubicacion = $request->input('ubicacion');
        if ($request->input('presencial')){
            $peticion->presencial = 1;
        } else{
            $peticion->presencial = 0;
        }
        

        $peticion->save();

        return redirect()->route('peticiones.index', [$peticion])->with('info', 'Petición actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $peticion = Peticion::findOrFail($id);
        $peticion->baja = 1;
        $peticion->save();
        
        return redirect()->route('peticiones.index', [$peticion])->with('info', 'Peticion dada de baja correctamente');
    }
}
