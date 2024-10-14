@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Aggiungi una nuova Tecnologia</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- resources/views/admin/technologies/create.blade.php -->
        <form action="{{ route('admin.technologies.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nome della Tecnologia</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Crea Tecnologia</button>
        </form>
    </div>
@endsection
