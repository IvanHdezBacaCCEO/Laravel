@extends('dashboard.master')

@section('content')

    <div class="col-6 mb-3">
        <form action="{{ route('post-comment.post', 1) }}" id="filterForm">
            <div class="row">
                <div class="col-10">
                    <select id="filterPost" class="form-control">
                        @foreach ($posts as $p)
                            <option value="{{ $p->id }}" {{ $post->id == $p->id ? 'selected' : '' }}>
                                {{ Str::limit($p->title, 60) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-2">
                    <button type="submit" class="btn btn-success">Enviar</button>
                </div>
            </div>
        </form>
    </div>



    @if (count($postComments) > 0)

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

                            <button data-bs-id="{{ $postComment->id }}"
                                class="approved btn btn-{{ $postComment->approved == 1 ? 'success' : 'danger' }}">
                                {{ $postComment->approved == 1 ? 'Aprobado' : 'Rechazado' }}
                            </button>

                            <button data-bs-toggle="modal" data-bs-target="#deleteModal"
                                data-bs-id="{{ $postComment->id }}" class="btn btn-danger">Eliminar</button>

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
                        <form id="formDelete" action="{{ route('post-comment.destroy', 0) }}"
                            data-action="{{ route('post-comment.destroy', 0) }}" method="postComment">
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
                var action = document.getElementById('formDelete').getAttribute('data-action').slice(0, -1) + id;
                document.getElementById('formDelete').action = action;
                var modalTitle = exampleModal.querySelector('.modal-title')
                modalTitle.textContent = 'Vas a borrar el POST: ' + id
            })
        </script>

    @else

        <h1>Ho hay comentarios para el post seleccionado</h1>

    @endif

    <script>
        document.querySelectorAll(".approved").forEach(button => button.addEventListener('click', () => {
            console.log('Hola mundo: ' + button.getAttribute('data-bs-id'));

            var id = button.getAttribute("data-bs-id");
            var formData = new FormData();
            formData.append("_token", '{{ csrf_token() }}');
            fetch("{{ URL::to('/') }}/dashboard/post-comment/process/" + id, {
                    method: 'POST',
                    body: formData
                }).then(response => response.json())
                .then(approved => {
                    if (approved == 1) {
                        button.classList.remove('btn-danger');
                        button.classList.add('btn-success');
                        button.innerHTML = 'Aprobado';
                    } else {
                        button.classList.add('btn-danger');
                        button.classList.remove('btn-success');
                        button.innerHTML = 'Rechazado';
                    }
                })

        }));


        window.onload = function() {
            var filterForm = document.getElementById('filterForm');
            var filterPost = document.getElementById('filterPost');
            filterForm.addEventListener('submit', (elem) => {
                console.log(filterPost.value);
                var action = filterForm.getAttribute('action');
                console.log(action);
                filterForm.setAttribute('action', filterForm.getAttribute('action').replace(/[0-9]/g, filterPost
                    .value));
                console.log(filterForm.getAttribute('action'));
            });
        }
    </script>

@endsection
