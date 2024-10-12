@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Crea Nuova Tipologia</h1>
        <form action="{{ route('admin.types.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nome Tipologia</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <button type="submit" class="btn btn-primary">Crea</button>
        </form>
    </div>
@endsection
