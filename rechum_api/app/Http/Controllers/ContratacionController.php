<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contratacion;
use App\Models\Personal;

class ContratacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        // recuperar los valores recibidos
        $params = $request->all();
        // crear un nuevo objeto en la DB
        $contrato = Contratacion::create($params);
        $contrato->save();
        if($contrato->status === 'NUEVO') {
            $personal = Personal::findOrFail($contrato->rfc);
            //Sustituye la contratacion "actual" por la recien creada
            foreach ($personal->contrataciones as $_contrato){
                $_contrato->update(['actual' => false, 'status' =>'HISTORICO']);
                $_contrato->save();
            }
            $contrato->actual = true;
            $contrato->status = 'ACTIVO';
            $contrato->save();
            // reactiva al personal
            $personal->status = 'ACTIVO';
            $personal->save();
        }

        
        // regresar una respuesta
        return response()->json($contrato);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        // recuperar los valores recibidos
        $params = $request->all();
        // busco en la BD
        $contrato = Contratacion::findOrFail($id);
        $personal = Personal::findOrFail($contrato->rfc);
        if(isset($params['status']) && $params['status'] === 'NUEVO') {
            $params['status'] = 'ACTIVO';
        }
        //actualizar los valores en la BD
        $contrato->update($params);
        if(isset($params['status']) && ($params['status'] === 'ACTIVO' || $params['status'] === 'BAJA' )) {
            // actualiza el status de la persona
            $personal->status = $params['status'];
            $personal->save();
        }
        // regresar una respuesta
        return response()->json($contrato);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $contrato = Contratacion::findOrFail($id);
        $contrato->delete();
        if($contrato->actual){
            $personal = Personal::findOrFail($contrato->rfc);
            $personal->status = "SIN ASIGNAR";
            if(sizeof($personal->contrataciones)>0){
                $_contrato = $personal->contrataciones->first();
                $_contrato->update(['actual'=> true, 'status' => 'BAJA']);
                $_contrato->save();
                $personal->status = "BAJA";
            }
            $personal->save();
        }
        return response()->json($contrato);
    }
}
