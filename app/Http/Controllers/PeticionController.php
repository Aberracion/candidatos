<?php

namespace Candidatos\Http\Controllers;

use Candidatos\Peticion;
use Candidatos\Candidato;
use Candidatos\Poblacion;
use Illuminate\Http\Request;
use DB;

class PeticionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['admin', 'super']);
        $peticiones = Peticion::where('baja', 0)->paginate(10);
         return view('peticiones.index', compact('peticiones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
       $request->user()->authorizeRoles(['admin', 'super']); 
       $candidatos_libres = Candidato::where('baja', 0)
            ->get();

        return view('peticiones.create', compact('candidatos_libres'))->with('editar',1);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->user()->authorizeRoles(['admin', 'super']);
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
        if (!empty($request->destino)){
            foreach($request->destino as $asignado){
                $peticion->candidatos()->attach($asignado[0]);
            }
        }
        if (!empty($request->origen)){
            foreach($request->origen as $asignado){
                $peticion->candidatos()->detach($asignado[0]);
            }
        } 

        return redirect()->route('peticiones.index')->with('info', 'Petición creada exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $request->user()->authorizeRoles(['admin', 'super']);
        $peticion = Peticion::findOrFail($id);
        $candidatos = Candidato::where('baja', 0)
                ->get();
        $candidatos_id = array();
        foreach ($candidatos as $candidato){
            $candidatos_id[] = $candidato->id;
        }
        $asignaciones_id = array();
        foreach ($peticion->candidatos as $asignacion){
            $asignaciones_id[] = $asignacion->id;               
        }   

        $libres = array_diff($candidatos_id, $asignaciones_id);
        $candidatos_libres = array();
        foreach ($candidatos as $candidato){
            foreach ($libres as $libre){
                if ($candidato['id']==$libre){
                    $candidatos_libres[] = $candidato;
                }
            } 
        }
        return view('peticiones.create', compact('peticion', 'candidatos_libres'))->with('editar',0);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['admin', 'super']);
        $peticion = Peticion::findOrFail($id);
        $candidatos = Candidato::where('baja', 0)
                ->get();

        $candidatos_id = array();
        foreach ($candidatos as $candidato){
            $candidatos_id[] = $candidato->id;
        }
        $asignaciones_id = array();
        foreach ($peticion->candidatos as $asignacion){
            $asignaciones_id[] = $asignacion->id;
        }   

        $libres = array_diff($candidatos_id, $asignaciones_id);
        $candidatos_libres = array();
        foreach ($candidatos as $candidato){
            foreach ($libres as $libre){
                if ($candidato['id']==$libre){
                    $candidatos_libres[] = $candidato;
                }
            } 
        }
        
        return view('peticiones.create', compact('peticion', 'candidatos_libres'))->with('editar',1);
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
        $request->user()->authorizeRoles(['admin', 'super']);
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
        if (!empty($request->destino)){
            foreach($request->destino as $asignado){
                $peticion->candidatos()->attach($asignado[0]);
            }
        }
        if (!empty($request->origen)){
            foreach($request->origen as $asignado){
                $peticion->candidatos()->detach($asignado[0]);
            }
        }
        

        return redirect()->route('peticiones.index', [$peticion])->with('info', 'Petición actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $request->user()->authorizeRoles(['admin', 'super']);
        $peticion = Peticion::findOrFail($id);
        $peticion->baja = 1;
        $peticion->save();
        
        return redirect()->route('peticiones.index', [$peticion])->with('info', 'Peticion dada de baja correctamente');
    }
    
    public function autocomplete(Request $request)
    {
        $data = Poblacion::select("poblacion")
                ->where("poblacion","LIKE","%{$request->input('query')}%")
                ->get();

        $data_array = array();
        foreach ($data as $row)
            {
                $data_array[] = $row->poblacion;
            }
        return response()->json($data_array);
   
    }

}
