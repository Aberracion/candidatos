<?php

namespace Candidatos\Http\Controllers;

use Candidatos\Candidato;
use Candidatos\Perfil;
use Candidatos\Peticion;
use Candidatos\Candidato_peticione;
use Illuminate\Http\Request;

class CandidatoController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $request->user()->authorizeRoles(['admin', 'super']);
        $candidatos = Candidato::where('baja', 0)->paginate(10);
        return view('candidatos.index', compact('candidatos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $request->user()->authorizeRoles(['admin', 'super']);
        return view('candidatos.create')->with('editar', 1);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $request->user()->authorizeRoles(['admin', 'super']);
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

        if (!empty($request->destino)){
            foreach($request->destino as $asignado){
                $candidato->peticiones()->attach($asignado[0]);
            }
        }
        if (!empty($request->origen)){
            foreach($request->origen as $asignado){
                $candidato->peticiones()->detach($asignado[0]);
            }
        } 
        
        Perfil::actualizarPerfiles($candidato->id, $request->input('tecnologias'));

        return redirect()->route('candidatos.index')->with('info', 'Candidato creado exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id) {
        $request->user()->authorizeRoles(['admin', 'super']);
        $candidato = Candidato::findOrFail($id);
        $perfiles = Perfil::where('baja', 0)
                ->where('id_candidato', '=', $id)
                ->orderBy('nivel', 'desc')
                ->orderBy('tecnologia', 'asc')
                ->get();
        $peticiones = Peticion::where('baja', 0)
                ->get();
        $peticiones_id = array();
        foreach ($peticiones as $peticion){
            $peticiones_id[] = $peticion->id;
        }
        $asignaciones_id = array();
        foreach ($candidato->peticiones as $asignacion){
            $asignaciones_id[] = $asignacion->id;
        }     
        $libres = array_diff($peticiones_id, $asignaciones_id);
        $peticiones_libres = array();
        foreach ($peticiones as $peticion){
            foreach ($libres as $libre){
                if ($peticion['id']==$libre){
                    $peticiones_libres[] = $peticion;
                }
            } 
        }
        return view('candidatos.create', compact('candidato', 'perfiles', 'peticiones_libres'))->with('editar',0);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id) {
        $request->user()->authorizeRoles(['admin', 'super']);
        $candidato = Candidato::findOrFail($id);
        $perfiles = Perfil::where('baja', 0)
                ->where('id_candidato', '=', $id)
                ->orderBy('nivel', 'desc')
                ->orderBy('tecnologia', 'asc')
                ->get();

        $peticiones = Peticion::where('baja', 0)
                ->get();
        $peticiones_id = array();
        foreach ($peticiones as $peticion){
            $peticiones_id[] = $peticion->id;
        }
        $asignaciones_id = array();
        foreach ($candidato->peticiones as $asignacion){
            $asignaciones_id[] = $asignacion->id;
        }     
        $libres = array_diff($peticiones_id, $asignaciones_id);
        $peticiones_libres = array();
        foreach ($peticiones as $peticion){
            foreach ($libres as $libre){
                if ($peticion['id']==$libre){
                    $peticiones_libres[] = $peticion;
                }
            } 
        }

        return view('candidatos.create', compact('candidato', 'perfiles', 'peticiones_libres'))->with('editar',1);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $request->user()->authorizeRoles(['admin', 'super']);
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

        if (!empty($request->destino)){
            foreach($request->destino as $asignado){
                $candidato->peticiones()->attach($asignado[0]);
            }
        }
        if (!empty($request->origen)){
            foreach($request->origen as $asignado){
                $candidato->peticiones()->detach($asignado[0]);
            }
        } 

        Perfil::actualizarPerfiles($id, $request->input('tecnologias'));

        return redirect()->route('candidatos.index', [$candidato])->with('info', 'Candidato actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id) {
        $request->user()->authorizeRoles(['admin', 'super']);
        $candidato = Candidato::findOrFail($id);
        $candidato->baja = 1;
        $candidato->save();

        Perfil::where('baja', 0)
                ->where('id_candidato', '=', $id)
                ->update(['baja' => 1]);

        return redirect()->route('candidatos.index', [$candidato])->with('info', 'Candidato dado de baja correctamente');
    }

    public function reactivacion(Request $request) {
        $request->user()->authorizeRoles(['super']);
        $candidatos = Candidato::paginate(10);
        return view('candidatos.reactivar', compact('candidatos'));
    }

    public function reactivar(Request $request) {
        $request->user()->authorizeRoles(['super']);
        if ($request->ajax()) {
            $candidato = Candidato::findOrFail($request->input('id'));
            $candidato->baja = $request->input('option');
            $candidato->save();
            return response()->json("OK");
        }
    }

}
