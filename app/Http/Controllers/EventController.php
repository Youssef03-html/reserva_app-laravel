<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    // Aquest mètode carga tots els events juntament amb la seva categoria, i filtra aquells que la quantitat de reserves sigui menys del màxim permés.
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
      
        return view('events.index', compact('groupedEvents'));
    }
    
    // Mostra detalladament els esdeveniments
    public function show($id) 
    {
        $event = Event::with('category', 'users')->findOrFail($id);
        $available = $event->availableSeats(); // Calculo les entrades disponibles amb el mètode correcte.

        return view('events.show', compact('event', 'available'));
    }

    // Mètode per reservar plaça per a un esdeveniment, amb diverses comprovacions, abans de reservar
    public function reserve(Request $request, $id) 
    {
        $event = Event::findOrFail($id);
        $user = Auth::user();
        
        // Verifico que l'usuari tingui la data de naixament configurada
        if (!$user->birth_date) {
            return redirect()->back()->with('error', 'Has de completar la teva data de naixament.');
        } 

        // Calculo l'edat de l'usuari
        $age = date_diff(date_create($user->birth_date), date_create('today'))->y;

        // Verifico l'edat mínima requerida
        if ($age < $event->min_age) {
            return redirect()->back()->with('error', 'No compleixes el requisit de l\'edat mínima per aquest esdeveniment.');
        } 

        // Verifico que encara hi hagin entrades disponibles
        if ($event->availableSeats() <= 0) {
            return redirect()->back()->with('error', 'No queden entrades disponibles per aquest esdeveniment.');
        }

        // Evito reserves duplicades
        if ($event->users()->where('user_id', $user->id)->exists()) {
            return redirect()->back()->with('error', 'Ja has reservat en aquest esdeveniment.');
        }

        // Registro la reserva
        $event->users()->attach($user->id);

        return redirect()->back()->with('success', 'Reserva realitzada correctament!');
    }
}
