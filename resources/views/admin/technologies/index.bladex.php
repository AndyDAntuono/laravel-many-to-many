@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Technologies</h1>
        <a href="{{ route('admin.technologies.create') }}" class="btn btn-primary mb-3">Add New Technology</a>
        
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($technologies as $technology)
                    <tr>
                        <td>{{ $technology->name }}</td>
                        <td>
                            <a href="{{ route('admin.technologies.edit', $technology->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.technologies.destroy', $technology->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
