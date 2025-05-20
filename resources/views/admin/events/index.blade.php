@extends('layouts.app')

@section('title', 'Gestió d\'Esdeveniments')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="mb-0">Gestió d'Esdeveniments</h1>
    <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Crear Nou
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>Nom</th>
                <th>Data</th>
                <th>Hora</th>
                <th>Categoria</th>
                <th class="text-center">Accions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($events as $event)
                <tr>
                    <td>{{ $event->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($event->time)->format('H:i') }}</td>
                    <td>{{ $event->category->name ?? 'N/A' }}</td>
                    <td class="text-center">
                        <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-sm btn-warning me-1">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Estàs segur que vols eliminar aquest esdeveniment?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No hi ha esdeveniments disponibles.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
