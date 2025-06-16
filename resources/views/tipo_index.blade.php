@extends("layouts.app")

@section("content")

    <div class="container col-md-10">
        <div class="card">
            <div class="card-header">
                Tipos de pokemons
            </div>
            <div class="card-body">
                <form action="{{route("tipos.index")}}" method="get">
                    <div class="row align-items-center justify-content-end g-2 mb-3">
                        <div class="col-md-3">
                            <input type="text" name="descripcion" value="{{old("descripcion")}}" class="form-control"
                                   placeholder="Buscar por descripción">
                        </div>
                        <div class="col-md-auto text-center">
                            <button class="btn btn-primary">Buscar</button>
                        </div>
                    </div>
                </form>

                @if(session("mensaje"))
                    <div class="alert alert-{{session("danger")?"danger":"success"}}">
                        {{session("mensaje")}}
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr class="text-center align-middle">
                            <th>Id</th>
                            <th>Descripción</th>
                            <th>
                                <a href="{{route("tipos.create")}}" class="btn btn-primary">Nuevo</a>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tipos as $tipo)
                            <tr class="align-middle">
                                <td class="col-3 text-end">{{$tipo->id}}</td>
                                <td class="col-6 text-center">{{$tipo->descripcion}}</td>
                                <td class="col-3 text-center">
                                    <div class="btn-group">
                                        <a href="{{route("tipos.edit", $tipo)}}" class="btn btn-primary">Editar</a>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{$tipo->id}}">
                                            Eliminar
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <!-- Modal -->
                            <div class="modal fade" id="deleteModal{{$tipo->id}}" tabindex="-1"
                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminar tipo</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            ¿Desea eliminar el tipo de pokemon seleccionado?
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{route("tipos.destroy", $tipo)}}" method="post">
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
            </div>
        </div>
    </div>

@endsection
