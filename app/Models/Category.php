<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // això premet la assignació massiva per al camp "name" (per a que no em doni errors més endavant com en l'anterior projecte)
    protected $fillable = ['name'];


    // relació: 1 categoria te més d'un event
    public function events() 
    {
        return $this->hasMany(Event::class);
    }
}
