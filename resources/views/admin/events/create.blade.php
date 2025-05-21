@extends('layouts.app')

@section('title', 'Crear Nou Esdeveniment')

@section('content')
<div class="mb-4">
    <h1>Crear Nou Esdeveniment</h1>
</div>

{{-- Errors de validació --}} <!-- si hi ha algun error, els mostro-->
@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('admin.events.store') }}">
    @csrf

    <div class="mb-3">
        <label for="name" class="form-label">Nom de l’Esdeveniment</label>
        <input type="text"
               class="form-control @error('name') is-invalid @enderror"
               id="name"
               name="name"
               value="{{ old('name') }}" 
               required>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Descripció</label>
        <textarea class="form-control @error('description') is-invalid @enderror"
                  id="description"
                  name="description"
                  rows="4"
                  required>{{ old('description') }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="row">
        <div class="mb-3 col-md-4">
            <label for="date" class="form-label">Data</label>
            <input type="date"
                   class="form-control @error('date') is-invalid @enderror"
                   id="date"
                   name="date"
                   value="{{ old('date') }}"
                   required>
            @error('date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="time" class="form-label">Hora</label>
            <input type="time"
                   class="form-control @error('time') is-invalid @enderror"
                   id="time"
                   name="time"
                   value="{{ old('time') }}"
                   required>
            @error('time')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="row">
        <div class="mb-3 col-md-4">
            <label for="max_attendees" class="form-label">Aforament Màxim</label>
            <input type="number"
                   class="form-control @error('max_attendees') is-invalid @enderror"
                   id="max_attendees"
                   name="max_attendees"
                   value="{{ old('max_attendees') }}"
                   required>
            @error('max_attendees')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="min_age" class="form-label">Edat Mínima</label>
            <input type="number"
                   class="form-control @error('min_age') is-invalid @enderror"
                   id="min_age"
                   name="min_age"
                   value="{{ old('min_age') }}"
                   required>
            @error('min_age')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="mb-3">
        <label for="category_id" class="form-label">Categoria</label>
        <select class="form-select @error('category_id') is-invalid @enderror"
                id="category_id"
                name="category_id"
                required>
            <option value="">-- Selecciona una categoria --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                {{ $category->name }}
            </option>
            @endforeach
        </select>
        @error('category_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">URL de la Imatge (opcional)</label>
        <input type="text"
               class="form-control @error('image') is-invalid @enderror"
               id="image"
               name="image"
               value="{{ old('image') }}"
               placeholder="exemple https://...">
        @error('image')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-success">
        <i class="bi bi-check2-circle"></i> Guardar
    </button>
    <a href="{{ route('admin.events.index') }}" class="btn btn-secondary ms-2">Cancel·lar</a>
</form>
@endsection
