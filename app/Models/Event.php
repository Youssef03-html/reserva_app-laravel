<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // permetem l'assignació masiva per aquests camps (per a que no em doni errors més endavant com en l'anterior projecte)
    protected $fillable = [
        'name',
        'description',
        'date',
        'time',
        'max_attendees',
        'min_age',
        'image',
        'category_id'
    ];

    // Relació event pertany a una categoria
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relació molts usuaris poden reservar un esdeveniment (event)
    public function users()
    {
        return $this->belongsToMany(User::class, 'event_user');
    }

    // Mètode auxiliar per contar les reserver
    public function reservationsCount() 
    {
        return $this->users()->count();
    }

    // Mètode auxiliar per calcular quantes entrades estan disponibles
    public function availableSeats() 
    {
        return $this->max_attendees - $this->reservationsCount(); // calculo les entrades disponibles restant el nombre de reserves.
    }
}


