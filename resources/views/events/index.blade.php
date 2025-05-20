{{-- resources/views/events/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Esdeveniments')

@section('content')
  <div class="mb-4">
    <h1 class="display-5">Pròxims Esdeveniments</h1>
  </div>

  @foreach($groupedEvents as $categoryName => $events)
    @if($events->count())
      <h2 class="mt-5 mb-3">{{ $categoryName }}</h2>
      <div class="row g-4">
        @foreach($events as $event)
          @php $available = $event->availableSeats(); @endphp
          <div class="col-md-4">
            <div class="card h-100 shadow-sm">
              @if($event->image)
                <img src="{{ asset($event->image) }}" alt="{{ $event->name }}">
              @else
                <div class="card-img-top bg-secondary text-white 
                            d-flex align-items-center justify-content-center"
                     style="height:200px;">
                  Sense imatge
                </div>
              @endif

              <div class="card-body d-flex flex-column">
                <h5 class="card-title">{{ $event->name }}</h5>
                <p class="card-text mb-1">
                  <i class="bi bi-calendar-event"></i>
                  {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}
                </p>
                <p class="card-text mb-3">
                  <i class="bi bi-clock"></i>
                  {{ \Carbon\Carbon::parse($event->time)->format('H:i') }}
                </p>
                <p class="mt-auto">
                  <span class="badge bg-success">{{ $available }} places</span>
                </p>
                <a href="{{ route('events.show', $event) }}"
                   class="btn btn-primary mt-3">
                  Veure detall
                </a>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  @endforeach

  @if($groupedEvents->isEmpty())
    <p>No hi ha esdeveniments disponibles.</p>
  @endif
@endsection
