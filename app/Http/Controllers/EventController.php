<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    
    // Aquest mètode carga tots els events juntament amb la seva categoria, i filtra aquells que la quantitat de reserves sigui menos del máxim permés.
    public function index() 
    {
        // Recupero els events juntament amb la seva relació de categoria.
        $events = Event::with('category')->get()->filter(function ($event) {
            return $event->reservationsCount() < $event->max_attendees;
        });

        // Agrupem els events per el nom de categoria
        $groupedEvents = $events->groupBy(function ($event) {
            return $event->category->name;
        });
      
        return view('events.index', compact('gropuedEvents'));
    }
    
    // mostrara detalladament els esdeveniments
    public function show($id) 
    {
        $event = Event::with('category', 'users')->findOrFail($id);
        $available = $event->availableSeats(); // Calculo les entrades disponibles, ajudant-me del metodo que vaig crear en el model de event.

        return view('events.show', compact('event', 'available'));
    }

    // Metodre per reservar plaça per a un esdeveniment, amb varies comprobacions, abans de reservar
    public function reserve(Request $request, $id) 
    {
        $event = Event::findOrFail($id);
        $user = Auth::user();

        // Verifico que l'usuari tingui la data de naixament configurada
        if (!$user->birth_date) 
        {
            return redirect()->back()->with('error', 'Has de completar la teva data de naixament.');
        } 

        // calculo l'edat de l'usuari
        $age = date_diff(date_create($user->birth_date), date_create('today'))->y;

        // Verifico l'edat minima requerida
        if ($age < $event->min_age) 
        {
            return redirect()->back()->with('error', 'No cunpleixes el requisit de l\'edat minima per aquest esdeveniment.');
        } 

        // Verifico que encara hi hagui entrades disponibles
        if ($event->avaiableSeats() <= 0) 
        {
            return redirect()->back()->with('error','No queden entrades disponibles per aquest esdeveniment.');
        }

        // Evito reserver duplicades
        if ($event->users()->where('user_id', $user->id)->exists()) 
        {
            return redirect()->back()->with('error','Ja has reservat en aquest esdeveniment.');
        }

        // Registro la reserva si passa totes les anteriors comprobacions.
        $event->users()->attach($user->id);

        return redirect()->back()->with('succes', 'Reserva realitzada correctament!');
    }
}
