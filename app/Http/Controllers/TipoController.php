<?php

namespace App\Http\Controllers;

use App\Models\Tipo;
use Illuminate\Http\Request;

class TipoController extends Controller
{
    public function validarForm(Request $request)
    {
        $request->validate([
            "descripcion" => "required|string|min:3|max:50"
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tipos = Tipo::where("descripcion", "like", "%$request->descripcion%")->get();
        session()->flashInput($request->input());
        return view("tipo_index", ["tipos" => $tipos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("tipo_create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validarForm($request);
        Tipo::create($request->all());
        return redirect()->route("tipos.index")->with(["mensaje" => "Tipo de pokemon creado"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tipo = Tipo::findOrFail($id);
        return $tipo;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tipo = Tipo::findOrFail($id);
        return view("tipo_edit", ["tipo" => $tipo]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validarForm($request);
        $tipo = Tipo::findOrFail($id);
        $tipo->update($request->all());
        return redirect()->route("tipos.index")->with(["Tipo de pokemon editado"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tipo = Tipo::findOrFail($id);
        if ($tipo->relPokemon()->exists())
            return redirect()->route("tipos.index")
                ->with(["mensaje" => "No es posible eliminar. El tipo $tipo->descripcion posee varios pokemons", "danger" => "danger"]);
        $tipo->delete();
        return redirect()->route("tipos.index")->with(["mensaje" => "Tipo de pokemon eliminado"]);
    }
}
