{{-- resources/views/events/show.blade.php --}}
@extends('layouts.app')

@section('title', $event->name)

@section('content')
  <div class="mb-4">
    <h1 class="display-5">{{ $event->name }}</h1>
    <p class="text-muted">Categoria: {{ $event->category->name }}</p>
  </div>

  <div class="row">
    <div class="col-md-6">
      @if($event->image)
        <div class="col-md-4 text-center">
          <img src="{{ asset($event->image) }}"
              class="img-fluid rounded shadow-sm"
              style="width: 100%; max-height: 400px; object-fit: cover;"
              alt="Imatge de l'esdeveniment">
        </div>
      @else
        <div class="bg-secondary text-white d-flex align-items-center justify-content-center rounded" style="height: 300px;">
          Sense imatge
        </div>
      @endif
    </div>

    <div class="col-md-6">
      <p>{{ $event->description }}</p>

      <ul class="list-group list-group-flush mb-3">
        <li class="list-group-item">
          <i class="bi bi-calendar-event"></i>
          {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}
        </li>
        <li class="list-group-item">
          <i class="bi bi-clock"></i>
          {{ \Carbon\Carbon::parse($event->time)->format('H:i') }}
        </li>
        <li class="list-group-item">
          <i class="bi bi-people"></i>
          Llocs disponibles: <strong>{{ $available }}</strong>
        </li>
        <li class="list-group-item">
          Edat mínima: <strong>{{ $event->min_age }} anys</strong>
        </li>
      </ul>

      {{-- Flash messages --}}
      @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
      @endif
      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif

      @if($available > 0)
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reserveModal">
          Reservar plaça
        </button>
      @else
        <button class="btn btn-secondary" disabled>No hi ha places</button>
      @endif
    </div>
  </div>

  <!-- Modal de confirmació -->
  <div class="modal fade" id="reserveModal" tabindex="-1" aria-labelledby="reserveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="reserveModalLabel">Confirmar Reserva</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tancar"></button>
        </div>
        <div class="modal-body">
          <p>Estàs reservant per a:</p>
          <p><strong>{{ $event->name }}</strong></p>
          <p>
            {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}
            a les {{ \Carbon\Carbon::parse($event->time)->format('H:i') }}
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            Cancel·lar
          </button>
          <form action="{{ route('events.reserve', $event->id) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-primary">Confirmar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
