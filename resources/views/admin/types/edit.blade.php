@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Modifica Tipologia</h1>
        <form action="{{ route('admin.types.update', $type->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Nome Tipologia</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $type->name }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Salva Modifiche</button>
        </form>
    </div>
@endsection
