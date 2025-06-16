@extends("layouts.app")

@section("content")

    <div class="container col-md-10">
        <div class="card">
            <div class="card-header">
                Editar el tipo de pokemon
            </div>
            <div class="card-body">

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{route("tipos.update", $tipo)}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <input type="text" name="descripcion" id="descripcion"
                               value="{{old("descripcion", $tipo->descripcion)}}"
                               class="form-control">
                    </div>
                    <div class="text-center">
                        <button class="btn btn-primary">Guardar</button>
                        <a href="{{route("tipos.index")}}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
