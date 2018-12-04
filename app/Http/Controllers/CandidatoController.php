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
        return view('candidatos.create')->with('editar',1);
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

        //$tecnologias = $request->input('tecnologias');
        
        Perfil::actualizarPerfiles($candidato->id, $request->input('tecnologias'));

        return redirect()->route('candidatos.index')->with('info', 'Candidato creado exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $candidato = Candidato::findOrFail($id);
        $perfiles = Perfil::where('baja', 0)
                ->where('id_candidato', '=', $id)
                ->orderBy('nivel', 'desc')
                ->orderBy('tecnologia', 'asc')
                ->get();
        return view('candidatos.create', compact('candidato', 'perfiles'))->with('editar',0);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $candidato = Candidato::findOrFail($id);
        $perfiles = Perfil::where('baja', 0)
                ->where('id_candidato', '=', $id)
                ->orderBy('nivel', 'desc')
                ->orderBy('tecnologia', 'asc')
                ->get();

        return view('candidatos.create', compact('candidato', 'perfiles'))->with('editar',1);
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

        Perfil::actualizarPerfiles($id, $request->input('tecnologias'));

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

        Perfil::where('baja', 0)
                ->where('id_candidato', '=', $id)
                ->update(['baja' => 1]);
        
        return redirect()->route('candidatos.index', [$candidato])->with('info', 'Candidato dado de baja correctamente');
    }

}
