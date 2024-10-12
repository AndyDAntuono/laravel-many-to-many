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
            <p><strong>Project Type:</strong> 
                {{ $project->type ? $project->type->name : 'No type assigned' }}
            </p>

            <!-- Pulsante per tornare alla lista dei progetti -->
            <a href="{{ route('projects.index') }}" class="btn btn-secondary">Back to Projects</a>

            <!-- Pulsante per modificare il progetto -->
            <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-primary">Edit Project</a>

            <!-- Form per eliminare il progetto -->
            <form action="{{ route('projects.destroy', $project->id) }}" method="POST" class="d-inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger"
                    onclick="return confirm('Are you sure you want to delete this project?');">
                    Delete Project
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
