@extends('dashboard.master')

@section('content')

    <a class="btn btn-success btn-sm my-3" href="{{ route('user.create') }}">Crear</a>

    <table class="table">
        <thead>
            <tr>
                <td>Id</td>
                <td>Nombre</td>
                <td>Apellido</td>
                <td>Email</td>
                <td>Rol</td>
                <td>Actualizacion</td>
                <td>Acciones</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->surname }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->rol->key }}</td>
                    <td>{{ $user->created_at->format('d-m-Y') }}</td>
                    <td>{{ $user->updated_at->format('d-m-Y') }}</td>
                    <td>
                        <a href="{{ route('user.show', $user->id) }}" class="btn btn-primary">Ver</a>
                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary">Actualizar</a>

                        <button data-bs-toggle="modal" data-bs-target="#deleteModal" data-bs-id="{{ $user->id }}"
                            class="btn btn-danger">Eliminar</button>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </form>

    {{ $users->links() }}

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Seguro que desea borrar el registro seleccionado?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <form id="formDelete" action="{{ route('user.destroy', 0)}}" data-action="{{ route('user.destroy', 0)}}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger">Borrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        var exampleModal = document.getElementById('deleteModal')
        exampleModal.addEventListener('show.bs.modal', function(event) {
            //console.log("Modal abierto")
            var button = event.relatedTarget
            var id = button.getAttribute('data-bs-id')
            var action = document.getElementById('formDelete').getAttribute('data-action').slice(0,-1) + id;
            document.getElementById('formDelete').action=action;
            console.log(action);
            var modalTitle = exampleModal.querySelector('.modal-title')
            modalTitle.textContent = 'Vas a borrar la categoria: ' + id
        })
    </script>

@endsection
