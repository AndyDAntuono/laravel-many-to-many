@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Lista delle Tecnologie</h1>

        <table class="table mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Slug</th>
                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody>
                @foreach($technologies as $technology)
                    <tr>
                        <td>{{ $technology->id }}</td>
                        <td>{{ $technology->name }}</td>
                        <td>{{ $technology->slug }}</td>
                        <td>
                            <a href="{{ route('admin.technologies.edit', $technology->id) }}" class="btn btn-warning">Modifica</a>

                            <!-- Bottone per mostrare la modale -->
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $technology->id }}">
                                Elimina
                            </button>

                            <!-- Modale di conferma eliminazione -->
                            <div class="modal fade" id="deleteModal{{ $technology->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $technology->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $technology->id }}">Conferma eliminazione</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Sei sicuro di voler eliminare la tecnologia <strong>{{ $technology->name }}</strong>?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                            <form action="{{ route('admin.technologies.destroy', $technology->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Elimina</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- Fine modale -->
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
