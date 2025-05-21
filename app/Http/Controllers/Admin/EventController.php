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
        // Recolleixo totes les categories
        $categories = Category::all();

        // Redirigeixo al a vista amb el formulari per crear un nou esdeveniment, pasant-li les categories, per a que quan crei pugui triar la categoria que vulgui
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
            'date'           => 'required|date|after_or_equal:today',
            'time'           => 'required',
            'max_attendees'  => 'required|integer|min:1',
            'min_age'        => 'required|integer|min:0',
            'image'          => 'nullable|url', 
            'category_id'    => 'required|exists:categories,id',
        ]);

        // Creo l'esdeveniment amb la informació ja validada
        Event::create($validated);

        // Redirigeixo al index d'events amb un missatge de confirmacio
        return redirect()->route('admin.events.index')->with('success', 'Evento creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Busco l'esdveniment per ID
        $event = Event::findOrFail($id);

        // Redirigeixo a la visa show amb lobjecte de l'esdeveniment
        return view('admin.events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       // Busco l'esdeveniiment per ID
        $event = Event::findOrFail($id);

        // Obtinc totes les categories
        $categories = Category::all();

        // Redirigeixo a la vista edit, pasant-li l'esdeveniment que vol editar l'admin i el llistat de cateogries
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
            'date'           => 'required|date|after_or_equal:today',
            'time'           => 'required',
            'max_attendees'  => 'required|integer|min:1',
            'min_age'        => 'required|integer|min:0',
            'image'          => 'nullable|url', 
            'category_id'    => 'required|exists:categories,id',
        ]);

        // Busco l'esdeveniment i l'actualitzo
        $event = Event::findOrFail($id);
        $event->update($validated); // Amb aquest mètode substitueixo els camps directament, sense haver d'anar 1 per 1

        // Redirigeixo a l'index amb un missatge de confirmació
        return redirect()->route('admin.events.index')->with('success', 'Evento actualizado correctamente.');
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

        // Redirigeixo al index amb un missatge de confirmació
        return redirect()->route('admin.events.index')->with('success', 'Evento eliminado correctamente.');
    }
}
