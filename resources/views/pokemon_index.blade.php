@extends("layouts.app")

@section("content")

    <div class="container col-md-10">
        <div class="card">
            <div class="card-header">
                Pokemons
            </div>
            <div class="card-body">

                <form action="{{route("pokemons.index")}}" method="get">
                    <div class="row align-items-center justify-content-end g-2 mb-3">
                        <div class="col-md-3">
                            <input type="text" name="nombre" value="{{old("nombre")}}" class="form-control"
                                   placeholder="Buscar por nombre">
                        </div>
                        <div class="col-md-auto text-center">
                            <button type="submit" class="btn btn-primary">Buscar</button>
                        </div>
                    </div>
                </form>

                @if(session("mensaje"))
                    <div class="alert alert-{{session("danger")?"danger":"success"}}">
                        {{session("mensaje")}}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead>
                        <tr class="text-center">
                            <th class="col-1">Id</th>
                            <th class="col-2">Nombre</th>
                            <th class="col-2">Peso</th>
                            <th class="col-2">Altura</th>
                            <th class="col-2">Tipo</th>
                            <th class="col-1">Foto</th>
                            <th class="col-2">
                                <a href="{{route("pokemons.create")}}" class="btn btn-primary">Nuevo</a>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pokemons as $pokemon)
                            <tr>
                                <td class="text-end">{{$pokemon->id}}</td>
                                <td class="text-start">{{$pokemon->nombre}}</td>
                                <td class="text-end">{{$pokemon->peso}}</td>
                                <td class="text-end">{{$pokemon->altura}}</td>
                                <td class="text-center">{{$pokemon->relTipo->descripcion}}</td>
                                <td><img src="{{url("imagenes/$pokemon->foto")}}" alt="foto de {{$pokemon->nombre}}"
                                         width="100" height="100" class="object-fit-contain"></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{route("pokemons.edit", $pokemon)}}"
                                           class="btn btn-primary">Editar</a>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{$pokemon->id}}">
                                            Eliminar
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <!-- Modal -->
                            <div class="modal fade" id="deleteModal{{$pokemon->id}}" tabindex="-1"
                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminar pokemon</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            ¿Desea eliminar al pokemon {{$pokemon->nombre}}?
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{route("pokemons.destroy", $pokemon)}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                            </form>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Cancelar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{$pokemons->links("pagination::bootstrap-4")}}

            </div>
        </div>
    </div>

@endsection
