<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class EventSeeder extends Seeder
{
    public function run()
    {
        $eventData = [
            'Música' => [
                [
                    'name' => 'Concert de Rock en viu',
                    'description' => 'Gaudeix d\'una nit inoblidable amb les millors bandes de rock locals en directe.',
                    'image' => 'images/events/rock.jpg',
                ],
                [
                    'name' => 'Festival de Jazz',
                    'description' => 'Un festival internacional de jazz que et portarà la millor música i improvisació.',
                    'image' => 'images/events/jazz.jpg',
                ],
                [
                    'name' => "Nit d'Orquestra Clàssica",
                    'description' => 'Una vetllada elegant amb la interpretació magistral d\'obres clàssiques.',
                    'image' => 'images/events/classica.jpg',
                ],
            ],
            'Teatre' => [
                [
                    'name' => 'Obra de Teatre Clàssic',
                    'description' => 'Una reinterpretació moderna d\'un dels clàssics del teatre amb actuacions sorprenents.',
                    'image' => 'images/events/teatreClassic.jpg',
                ],
                [
                    'name' => 'Comèdia en Escena',
                    'description' => 'Una nit plena de rialles amb un repartiment estel·lar i humor actual.',
                    'image' => 'images/events/teatreComedia.jpg',
                ],
                [
                    'name' => 'Drama Modern',
                    'description' => 'Un drama intens que reflecteix els dilemes i reptes de la societat contemporània.',
                    'image' => 'images/events/teatreDrama.jpg',
                ],
            ],
            'Cinema' => [
                [
                    'name' => 'Nit de Cinema Independiente',
                    'description' => 'Projectes audaciosos del món indie per a una vetllada ambient i alternativa.',
                    'image' => 'images/events/cienemaIndependent.jpg',
                ],
                [
                    'name' => 'Estrena de Pel·lícula',
                    'description' => 'No et perdis l\'estrena del moment amb un ambient de gala i celebració.',
                    'image' => 'images/events/cinemaEstreno.jpg',
                ],
                [
                    'name' => 'RetroCine: Clàssics del Cinema',
                    'description' => 'Un viatge nostàlgic pels grans clàssics que han fet història al cinema.',
                    'image' => 'images/events/cinemaRetro.jpeg',
                ],
            ],
            'Monòlegs' => [
                [
                    'name' => 'Nit de Stand-up',
                    'description' => 'Una vetllada plena d\'humor i rialles amb reconeguts comediants en directe.',
                    'image' => 'images/events/nocheStand.jpg',
                ],
                [
                    'name' => 'Monòlegs en Directe',
                    'description' => 'Comediants surten al seu real amb monòlegs que et faran cridar de riure.',
                    'image' => 'images/events/monoleg.jpg',
                ],
                [
                    'name' => "Humor a l'Escena",
                    'description' => 'Un espectacle íntim amb humor fresc i improvisació en directe.',
                    'image' => 'images/events/humorEscena.jpg',
                ],
            ],
            'Màgia' => [
                [
                    'name' => 'Espectacle Màgic Interactiu',
                    'description' => 'Una experiència interactiva plena de misteri i il·lusions per a tota la família.',
                    'image' => 'images/events/magiaInteractiva.jpg',
                ],
                [
                    'name' => 'Il·lusions i Misteris',
                    'description' => 'Descobreix els secrets de la màgia amb trucs sorprenents i captivadors.',
                    'image' => 'images/events/magiaIusiones.jfif',
                ],
                [
                    'name' => 'Magia per a Totes les Edats',
                    'description' => 'Un espectacle dissenyat per encantar tant petits com grans amb el seu encant i misteri.',
                    'image' => 'images/events/magiaJoven.jfif',
                ],
            ],
        ];

        foreach ($eventData as $categoryName => $events) {
            // Buscar la categoría por nombre
            $category = Category::where('name', $categoryName)->first();

            if (!$category) {
                continue;
            }

            foreach ($events as $data) {
                Event::create([
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'date' => Carbon::now()->addDays(rand(1, 30)),
                    'time' => Carbon::now()->addHours(rand(10, 20))->format('H:i'),
                    'max_attendees' => rand(50, 200),
                    'min_age' => rand(12, 18),
                    'image' => $data['image'],
                    'category_id' => $category->id,
                ]);
            }
        }
    }
}
