<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use App\Models\Tipo;
use Illuminate\Http\Request;

class PokemonController extends Controller
{
    public function validarForm(Request $request, bool $creando)
    {
        $request->validate([
            "nombre" => "required|string|min:3|max:50",
            "peso" => "required|numeric|min:0|max:99999999",
            "altura" => "required|numeric|min:0|max:99999999",
            "foto" => $creando ? "required|image|mimes:jpg,jpeg,png,gif|max:2048" : "image|mimes:jpg,jpeg,png,gif|max:2048",
            "tipos_id" => "required|numeric|min:1"
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pokemons = Pokemon::where("nombre", "like", "%$request->nombre%")->paginate(10);
        session()->flashInput($request->all());
        return view("pokemon_index", ["pokemons" => $pokemons]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tipos = Tipo::all();
        return view("pokemon_create", ["tipos" => $tipos]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validarForm($request, true);
        if ($foto = $request->file("foto")) {
            $input = $request->all();
            $fotoNombre = date("YmdHis") . "." . $foto->getClientOriginalExtension();
            $fotoRuta = "imagenes";
            $foto->move($fotoRuta, $fotoNombre);
            $input["foto"] = $fotoNombre;
            Pokemon::create($input);
        } else
            Pokemon::create($request->all());
        return redirect()->route("pokemons.index")->with(["mensaje" => "Pokemon creado"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Pokemon::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tipos = Tipo::all();
        $pokemon = Pokemon::findOrFail($id);
        return view("pokemon_edit", ["tipos" => $tipos, "pokemon" => $pokemon]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validarForm($request, false);
        $pokemon = Pokemon::findOrFail($id);
        if ($foto = $request->file("foto")) {
            $archivoAEliminar = "imagenes/$pokemon->foto";
            if (file_exists($archivoAEliminar))
                unlink($archivoAEliminar);
            $input = $request->all();
            $fotoNombre = date("YmdHis") . "." . $foto->getClientOriginalExtension();
            $fotoRuta = "imagenes";
            $foto->move($fotoRuta, $fotoNombre);
            $input["foto"] = $fotoNombre;
            $pokemon->update($input);
        } else
            $pokemon->update($request->all());
        return redirect()->route("pokemons.index")->with(["mensaje" => "Pokemon actualizado"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pokemon = Pokemon::findOrFail($id);
        $archivoAEliminar = "imagenes/$pokemon->foto";
        if (file_exists($archivoAEliminar))
            unlink($archivoAEliminar);
        $pokemon->delete();
        return redirect()->route("pokemons.index")->with(["mensaje" => "Pokemon eliminado"]);
    }
}
