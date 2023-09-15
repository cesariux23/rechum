<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movimiento;
use App\Models\Contratacion;

class MovimientoController extends Controller
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
        //
        $params = $request->input('movimiento');
        $params['funcion'] = strtoupper($params['funcion']);
        $movimiento = Movimiento::create($params);
        $movimiento->save();

        if( $movimiento->status === 'NUEVO' ) {
            // se desactiva el puesto actual anterior
            $actuales = Movimiento::where('contratacion_id', $movimiento->contratacion_id)->where('actual', 1)->get();
            foreach($actuales as $mov) {
                $mov->actual = false;
                $mov->save();
            }
            $movimiento->status = 'ACTIVO';
            $movimiento->actual = true;
            $movimiento->save();
        }
        return response()->json($movimiento);

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
        $movimiento = Movimiento::findOrFail($id);
        $params = $request->input('movimiento');
        $params['funcion'] = strtoupper($params['funcion']);
        $movimiento->update($params);
        return response()->json($movimiento);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $movimiento = Movimiento::findOrFail($id);
        $movimiento->delete();
        return response()->json($movimiento);
    }
}
