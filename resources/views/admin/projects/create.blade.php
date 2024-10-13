@extends('layouts.app')

@section('content')
    <h1>Crea un nuovo progetto</h1>

    <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Titolo</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Descrizione</label>
            <textarea name="description" id="description" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="image">Immagine</label>
            <input type="file" name="image" id="image" class="form-control"> <!-- Campo per l'upload dell'immagine -->
        </div>
        <div class="form-group">
            <label for="type_id">Tipologia</label>
            <select name="type_id" id="type_id" class="form-control">
                <option value="">Seleziona una tipologia</option>
                @foreach ($types as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="technologies">Technologies</label>
            <select name="technologies[]" id="technologies" class="form-control" multiple>
                @foreach($technologies as $technology)
                    <option value="{{ $technology->id }}"
                        {{ in_array($technology->id, old('technologies', $project->technologies->pluck('id')->toArray() ?? [])) ? 'selected' : '' }}>
                        {{ $technology->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>
@endsection
