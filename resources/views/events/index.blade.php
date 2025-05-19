@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Eventos Disponibles</h1>
  <!-- Foreach per mostrar tots els esdeveniments, agrupats per categoria -->
  @foreach($groupedEvents as $categoria => $events)
    <h2>{{ $categoria }}</h2>
    <div class="row">
      @foreach($events as $event)
        <div class="col-md-4">
          <div class="card mb-3">
            @if($event->image)
              <img src="{{ asset('storage/' . $event->image) }}" class="card-img-top" alt="Imagen de {{ $event->name }}">
            @endif
            <div class="card-body">
              <h5 class="card-title">{{ $event->name }}</h5>
              <p class="card-text">
                {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }} - {{ $event->time }} <!-- El carbon, es una biblioteca de php que esta disenyada per facilitar la manipulació de dates, la he trobat investigant per internet, maneres facils de manejar dates -->
                                                                                                <!-- Amb el format, es pot mostrar de manera personalitzada la data, format('d/m/y') ho mostrara com dia/mes/any--> 
              </p>
              <a href="{{ route('events.show', $event->id) }}" class="btn btn-primary">Veure detalls</a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @endforeach
</div>
@endsection
