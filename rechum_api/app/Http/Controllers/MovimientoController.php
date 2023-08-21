<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movimiento;

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
    }
}
