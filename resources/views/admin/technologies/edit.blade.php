@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Technology</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.technologies.update', $technology->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Technology Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $technology->name) }}" required>
            </div>

            <div class="form-group">
                <label for="technology_id">Select Technology</label>
                <select name="technology_id" id="technology_id" class="form-control">
                    @foreach($allTechnologies as $tech)
                        <option value="{{ $tech->id }}" {{ $tech->id === $technology->id ? 'selected' : '' }}>
                            {{ $tech->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-success">Update Technology</button>
        </form>
    </div>
@endsection
