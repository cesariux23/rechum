<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Catalogo;
use App\Models\Adscripcion;
use App\Models\plaza;

class CatalogosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // objeto para la UI
        $catalogos = Catalogo::all();
        $catalogos_ui = [];
        foreach ($catalogos as $cat) {
            $catalogos_ui[$cat->catalogo] = $cat->items;
        }

        // se agregan valores de la DB
        $catalogos_ui['adscripciones'] = Adscripcion::all();
        $catalogos_ui['plazas'] = Plaza::all();
        return $catalogos_ui;
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
