@extends('layouts.app')

@section('title', 'Editar Categoria')

@section('content')
<div class="mb-4">
    <h1>Editar Categoria</h1>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.categories.update', $category->id) }}">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="name" class="form-label">Nom de la Categoria</label>
        <input type="text" name="name" id="name"
               class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $category->name) }}" required>
        @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <button type="submit" class="btn btn-success">
        <i class="bi bi-check2-circle"></i> Actualitzar
    </button>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary ms-2">Cancel·lar</a>
</form>
@endsection
