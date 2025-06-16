@extends("layouts.app")

@section("content")

    <div class="container col-md-10">
        <div class="card">
            <div class="card-header">
                Dashboard
            </div>
            <div class="card-body">
                <h1>¡Bienvenido {{\Illuminate\Support\Facades\Auth::user()->name}}!</h1>
                <h4>Actualmente se han registrado {{$cantidadTipos}} tipos de pokemons</h4>
                <h4>Actualmente se han registrado {{$cantidadPokemons}} pokemons</h4>
                <center>
                    <h5>Atrápalos a todos!</h5>
                </center>
            </div>
        </div>
    </div>

@endsection
