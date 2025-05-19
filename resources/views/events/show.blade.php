@extends('layouts.app')

@section('content')
<div class="container">
  <h1>{{ $event->name }}</h1>
  
  @if($event->image)
    <img src="{{ asset('storage/' . $event->image) }}" class="img-fluid mb-3" alt="Imagen de {{ $event->name }}">
  @endif
  
  <p>{{ $event->description }}</p>
  <p><strong>Data:</strong> {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}</p>
  <p><strong>Hora:</strong> {{ $event->time }}</p>
  <p><strong>Entrades Disponibles:</strong> {{ $available }}</p>
  
  <!-- Botón para abrir el modal de reserva -->
  <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#reserveModal">
    Reserva!
  </button>
  
  <!-- Modal para confirmar la reserva -->
  <div class="modal fade" id="reserveModal" tabindex="-1" aria-labelledby="reserveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="POST" action="{{ route('events.reserve', $event->id) }}">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="reserveModalLabel">Confirmar Reserva</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <p>Desitjes confirmar la reserva <strong>{{ $event->name }}</strong>?</p>
            <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}</p> <!-- explicacio de Carbon en la vista index.blade.php de events -->
            <p><strong>Hora:</strong> {{ $event->time }}</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Confirmar Reserva</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
