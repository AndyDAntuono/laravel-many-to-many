@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>{{ $project->title }}</h1>

            <!-- Se presente, mostra l'immagine -->
            @if($project->image)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}" class="img-fluid">
                </div>
            @endif

            <!-- Descrizione del progetto -->
            <p>{{ $project->description }}</p>

            <!-- Tipologia del progetto (se presente) -->
            <p><strong>Tipologia del progetto:</strong> 
                {{ $project->type ? $project->type->name : 'Questo progetto non ha una tipologia' }}
            </p>

            <p><strong>Tecnologie utilizzate:</strong></p>
            <ul>
                @forelse($project->technologies as $technology)
                    <li>{{ $technology->name }}</li>
                @empty
                    <p>Questo progetto non utilizza nessuna tecnologia.</p>
                @endforelse
            </ul>

            <!-- Pulsante per tornare alla lista dei progetti -->
            <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">Torna ai progetti</a>

            <!-- Pulsante per modificare il progetto -->
            <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn btn-primary">Modifica progetto</a>

            <!-- Form per eliminare il progetto -->
            <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" class="d-inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger"
                    onclick="return confirm('Are you sure you want to delete this project?');">
                    Cancella progetto
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
