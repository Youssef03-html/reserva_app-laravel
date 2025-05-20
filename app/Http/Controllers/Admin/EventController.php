<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // recolleixo tots els events de la BD
        $events = Event::all();

        // Retorno la vista admin events, juntament amb tots els events
        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {    
        // Obtenemos todas las categorías
        $categories = Category::all();
        // Redirige a la vista con el formulario para crear un nuevo esdeveniment, pasando las categorías
        return view('admin.events.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valido l'informació rebuda
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'description'    => 'required|string',
            'date'           => 'required|date',
            'time'           => 'required',
            'max_attendees'  => 'required|integer',
            'min_age'        => 'required|integer',
            'category_id'    => 'required|exists:categories,id',
        ]);

        // Creo el esdeveniment amb la informació ja validada
        Event::create($validated);

        // Redirigim al index d'events amb un missatge
        return redirect()->route('admin.events.index')
        ->with('success', 'Evento creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Busco l'esdveniment per ID
        $event = Event::findOrFail($id);

        // Redirigeixo a la visa show amb l'event
        return view('admin.events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       // Buscamos el esdeveniment por ID
        $event = Event::findOrFail($id);

        // Obtenemos todas las categorías
        $categories = Category::all();

        // Redirigimos a la vista de edición, pasando el evento y la lista de categorías.
        return view('admin.events.edit', compact('event', 'categories'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Valido l'informació rebuda
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'description'    => 'required|string',
            'date'           => 'required|date',
            'time'           => 'required',
            'max_attendees'  => 'required|integer',
            'min_age'        => 'required|integer',
            'category_id'    => 'required|exists:categories,id',
        ]);

        // Trobo l'esdeveniment i l'actualitzo
        $event = Event::findOrFail($id);
        $event->update($validated); // Amb aquest metodo substitueixo els camps directament, sense haver d'anar 1 per 1

        // Redirigeixo a l'index amb un missatge d'exit
        return redirect()->route('admin.events.index')
        ->with('success', 'Evento actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         // Busco l'event que vull eliminar
        $event = Event::findOrFail($id);

        // L'elimino
        $event->delete();

        // Redirigeixo al index amb un missatge d'exit
        return redirect()->route('admin.events.index')
        ->with('success', 'Evento eliminado correctamente.');
    }
}
