<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Personal;

class PersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Personal::query();
        // Sí se envia un paramentro de busqueda
        if($request->has('search')){
            $search = trim(strtoupper($request->query('search')));
            $query->rfc($search)->orWhere->nombre($search);
        }

        // si se pide la lista completa
        return response()->json($query->paginate());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $params = $request->all();
        $params['rfc'] = strtoupper($params['rfc']);
        $params['curp'] = strtoupper($params['curp']);
        $params['nombre'] = strtoupper($params['nombre']);
        $params['primer_apellido'] = strtoupper($params['primer_apellido']);
        $params['segundo_apellido'] = strtoupper($params['segundo_apellido']);
        $params['nombre_completo'] = trim(join(' ',[$params['nombre'],$params['primer_apellido'],$params['segundo_apellido']]));
        $personal = Personal::create($params);
        
        $personal->save();
        return response()->json($personal);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $personal = Personal::with('contrataciones', 'contrataciones.movimientos', 'contrataciones.movimientos.adscripcion', 'contrataciones.movimientos.plaza')->findOrFail($id);
        return response()->json($personal);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $personal = Personal::find($id);
        $params = $request->all();
        $params['rfc'] = strtoupper($params['rfc']);
        $params['curp'] = strtoupper($params['curp']);
        $params['nombre'] = strtoupper($params['nombre']);
        $params['primer_apellido'] = strtoupper($params['primer_apellido']);
        $params['segundo_apellido'] = strtoupper($params['segundo_apellido']);
        $params['nombre_completo'] = trim(join(' ',[$params['nombre'],$params['primer_apellido'],$params['segundo_apellido']]));
        $personal->update($params);
        return response()->json($personal);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $personal = Personal::findOrFail($id);
        //TO-DO: revisar si es posible eliminar
        $personal->delete();
        return response()->json($personal);
    }
}
