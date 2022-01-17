@extends('dashboard.master')

@section('content')

@if (count($postComments)>0)

    <table class="table">
        <thead>
            <tr>
                <td>Id</td>
                <td>Titulo</td>
                <td>Aprovado</td>
                <td>Usuario</td>
                <td>Creacion</td>
                <td>Actualizacion</td>
                <td>Acciones</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($postComments as $postComment)
                <tr>
                    <td>{{ $postComment->id }}</td>
                    <td>{{ $postComment->title }}</td>
                    <td>{{ $postComment->approved }}</td>
                    <td>{{ $postComment->user->name }}</td>
                    <td>{{ $postComment->created_at->format('d-m-Y') }}</td>
                    <td>{{ $postComment->updated_at->format('d-m-Y') }}</td>
                    <td>
                        <a href="{{ route('post-comment.show', $postComment->id) }}" class="btn btn-primary">Ver</a>

                        <button data-bs-toggle="modal" data-bs-target="#deleteModal" data-bs-id="{{ $postComment->id }}"
                            class="btn btn-danger">Eliminar</button>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $postComments->links() }}

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
                    <form id="formDelete" action="{{ route('post-comment.destroy', 0)}}" data-action="{{ route('post-comment.destroy', 0)}}" method="postComment">
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
            modalTitle.textContent = 'Vas a borrar el POST: ' + id
        })
    </script>

@else
    
    <h1>Ho hay comentarios para el post seleccionado</h1>

@endif

@endsection
