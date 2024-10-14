@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Crea un nuovo progetto</h1>

        <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Titolo del progetto -->
            <div class="form-group">
                <label for="title">Titolo</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>

            <!-- Descrizione del progetto -->
            <div class="form-group">
                <label for="description">Descrizione</label>
                <textarea name="description" id="description" class="form-control" required></textarea>
            </div>

            <!-- Immagine del progetto -->
            <div class="form-group">
                <label for="image">Immagine</label>
                <input type="file" name="image" id="image" class="form-control">
            </div>

            <!-- Selezione della tipologia del progetto -->
            <div class="form-group">
                <label for="type_id">Tipologia</label>
                <select name="type_id" id="type_id" class="form-control">
                    <option value="">Seleziona una tipologia</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Selezione delle tecnologie (con checkbox) -->
            <div class="form-group">
                <label for="technologies">Technologies</label>
                <div>
                    @foreach($technologies as $technology)
                        <div class="form-check">
                            <input 
                                class="form-check-input" 
                                type="checkbox" 
                                name="technologies[]" 
                                id="technology{{ $technology->id }}" 
                                value="{{ $technology->id }}"
                            >
                            <label class="form-check-label" for="technology{{ $technology->id }}">
                                {{ $technology->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Pulsante per creare il progetto -->
            <button type="submit" class="btn btn-primary mt-3">Crea Progetto</button>
        </form>
    </div>
@endsection
