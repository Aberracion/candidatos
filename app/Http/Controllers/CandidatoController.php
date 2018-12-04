<?php

namespace Candidatos\Http\Controllers;

use Candidatos\Candidato;
use Candidatos\Perfil;
use Illuminate\Http\Request;

class CandidatoController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $candidatos = Candidato::where('baja', 0)->get();
        return view('candidatos.index', compact('candidatos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('candidatos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $candidato = new Candidato();
        $candidato->nombre = $request->input('nombre');
        $candidato->apellidos = $request->input('apellidos');
        $candidato->ubicacion = $request->input('ubicacion');
        $candidato->sede = $request->input('sede');
        $candidato->estado = $request->input('estado');
        if ($request->hasFile('cv')) {
            $file = $request->file('cv');
            $name = time() . $file->getClientOriginalName();
            $file->move(public_path() . '/docs/curriculums/', $name);
            $candidato->cv = $name;
        } else {
            $candidato->cv = "";
        }
        $candidato->baja = 0;
        $candidato->save();

        $tecnologias = $request->input('tecnologias');
        //return $tecnologias;
        foreach($tecnologias['name'] as $key => $tecn){
            $tecnologia = new Perfil();
            $tecnologia->tecnologia = $tecn;
            $tecnologia->nivel = $tecnologias['level'][$key];
            $tecnologia->id_candidato = $candidato->id;
            $tecnologia->baja=0;
            $tecnologia->save();
        }
        return redirect()->route('candidatos.index')->with('info', 'Candidato creado exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
//
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $candidato = Candidato::findOrFail($id);
        return view('candidatos.create', compact('candidato'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $candidato = Candidato::findOrFail($id);
        $candidato->nombre = $request->input('nombre');
        $candidato->apellidos = $request->input('apellidos');
        $candidato->ubicacion = $request->input('ubicacion');
        $candidato->sede = $request->input('sede');
        $candidato->estado = $request->input('estado');
        if ($request->hasFile('cv')) {
            $file_path = public_path() . '/docs/curriculums/' . $candidato->cv;
            \File::delete($file_path);
            $file = $request->file('cv');
            $name = time() . $file->getClientOriginalName();
            $file->move(public_path() . '/docs/curriculums/', $name);
            $candidato->cv = $name;
        }
        $candidato->save();

        return redirect()->route('candidatos.index', [$candidato])->with('info', 'Candidato actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $candidato = Candidato::findOrFail($id);
        $candidato->baja = 1;
        $candidato->save();
        return redirect()->route('candidatos.index', [$candidato])->with('info', 'Candidato dado de baja correctamente');
    }

}
