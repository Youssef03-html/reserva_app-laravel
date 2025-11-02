<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    // Aquest mètode del index carga tots els events juntament amb la seva categoria, i filtra aquells que la quantitat de reserves sigui menys del màxim permés.
    public function index() 
    {
        // Recupero els events juntament amb la seva relació de categoria, aixi evito consultes extes quan cridi a $event->category
        // amb el get executo la consulta y obtinc la coleccio de tots els esdeveniments de la bd
        // amb el filter recorro tots els elements de la coleccio, per decidir si els inclog o no
        $events = Event::with('category')->get()->filter(function ($event) {
            return $event->reservationsCount() < $event->max_attendees; // Si el numero de reserves es menor que el aforo maxim del esdeveniment, això retornarà true, en cas contrari retornara false. 
        }); // per tant si el esdeveniment ja no te places lliures no el mostrare al index.

        // Agrupem els events per el nom de categoria
        // el groupBy() m'agrupa els elements d'una coleccio, en aquest cas els esdeveniments per categoria (ja que en la funcio anonima li retorno la categoria al groupBy)
        $groupedEvents = $events->groupBy(function ($event) {
            return $event->category->name; // per a cada esdeveniment retornem el nom de la seva categoria
        });
      
        return view('events.index', compact('groupedEvents')); // retornem la vista index, i amb el compact un array associatiu dels envents (on la clau es el nom de la variable)
    }
    
    // Mostra detalladament els esdeveniments
    public function show($id) 
    {
        $event = Event::with('category', 'users')->findOrFail($id); // busco l'esdeveniment pel seu id 
        $available = $event->availableSeats(); // Calculo les entrades disponibles amb el mètode que he creat al model de Event
        return view('events.show', compact('event', 'available')); // retorno a la vista show, amb l'objecte event y tota la seva informacio i a part també retorno el nombre d'entrades disponibles del esdeveniment
    }

    // Mètode per reservar plaça per a un esdeveniment, amb diverses comprovacions, abans de reservar
    public function reserve(Request $request, $id) 
    {
        $event = Event::findOrFail($id);
        $user = Auth::user();
        
        // Verifico que l'usuari tingui la data de naixament configurada, ja que al principi no demanaba la data de naixament en el registre, pero ho deixo perque em sembla una comprobació bona que deixaria en alguna web feta per mi.
        if (!$user->birth_date) {
            return redirect()->back()->with('error', 'Has de completar la teva data de naixament.');
        } 

        // Calculo l'edat de l'usuari
        $age = date_diff(date_create($user->birth_date), date_create('today'))->y; // amb el date create creo un objecte de la data de naixament del usuari "$user->birth_date", i un altre objecte de la data actual "date_create('today')"
        // amb el date_diff() (funció de php) agafa 2 objectes de tipus data i calcula la diferencia entre ells, retornant un objecte que es divideix en y (any), m (mes), d(dia), aixo facilita molt la manera de 
        // treballar amb les dates.
        // al final retorno nomes el y (l'any), en aquest cas els anys de diferencia entre quan va neixer y la data actual.

        // Verifico l'edat mínima requerida ja amb l'edat que he calculat adalt
        if ($age < $event->min_age) {
            return redirect()->back()->with('error', 'No compleixes el requisit de l\'edat mínima per aquest esdeveniment.');
        } 

        // Verifico que encara hi hagin entrades disponibles amb el mètode que he creat al model d'Event
        if ($event->availableSeats() <= 0) {
            return redirect()->back()->with('error', 'No queden entrades disponibles per aquest esdeveniment.');
        }

        // Evito reserves duplicades
        // mitjançant una consulta "where" busca en els registres si en la columna 'user_id' hi ha algun id igual a "$user->id" en cas que existeixi,
        // el mètode exists() retorna true per tant retorno a la ultima vista amb el missatge d'error, en cas contrari "false", segueixo. 
        if ($event->users()->where('user_id', $user->id)->exists()) {
            return redirect()->back()->with('error', 'Ja has reservat en aquest esdeveniment.');
        }

        // Registro la reserva
        $event->users()->attach($user->id);

        // si tot va be, retorno amb un missatge de confirmació
        return redirect()->back()->with('success', 'Reserva realitzada correctament!');
    }

    // Mètode per cancelar la reserva, en cas que haguis fet
    public function cancelReservation(string $id)
    {
        $event = Event::findOrFail($id);
        $user = Auth::user();
      
        
        // Verificar que el usuario realmente tenga una reserva
        if (!$event->users()->where('user_id', $user->id)->exists()) {
            return redirect()->back()->with('error', 'No has reservat en aquest esdeveniment.');
        }
        
        // Cancelar la reserva
        $event->users()->detach($user->id);
        
        return redirect()->back()->with('success', 'Reserva cancelada.');
    }


}
 