@extends('layouts.app')

@section('title', 'Detall de l\'Esdeveniment')

@section('content')
<div class="mb-4">
    <h1>Detall de l'Esdeveniment</h1>
</div>

<div class="row mb-4">
    <div class="col-md-8">
        <h2 class="mb-3">{{ $event->name }}</h2>

        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <strong>Data:</strong> {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}
            </li>
            <li class="list-group-item">
                <strong>Hora:</strong> {{ \Carbon\Carbon::parse($event->time)->format('H:i') }}
            </li>
            <li class="list-group-item">
                <strong>Categoria:</strong> {{ $event->category->name ?? 'N/A' }}
            </li>
            <li class="list-group-item">
                <strong>Aforament Màxim:</strong> {{ $event->max_attendees }}
            </li>
            <li class="list-group-item">
                <strong>Edat Mínima:</strong> {{ $event->min_age }} anys
            </li>
        </ul>

        <div class="mt-4">
            <p>{{ $event->description }}</p>
        </div>
    </div>

   <div class="col-md-4 text-center">
    @if($event->image)
        <img src="{{ asset($event->image) }}"
             class="img-fluid rounded shadow"
             style="width: 100%; max-height: 400px; object-fit: cover;"
             alt="Imatge de l'esdeveniment">
    @else
        <img src="{{ asset('images/default-event.jpg') }}"
             class="img-fluid rounded shadow"
             style="width: 100%; max-height: 400px; object-fit: cover;"
             alt="Imatge per defecte">
    @endif
</div>
</div>

<div class="d-flex align-items-center gap-2">
    <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-warning">
        <i class="bi bi-pencil-square"></i> Editar
    </a>

    <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST"
          onsubmit="return confirm('Estàs segur que vols eliminar aquest esdeveniment?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">
            <i class="bi bi-trash"></i> Eliminar
        </button>
    </form>
</div>

<div class="mt-4">
    <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">
        Tornar al llistat
    </a>
</div>
@endsection
