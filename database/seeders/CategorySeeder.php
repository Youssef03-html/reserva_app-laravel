<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = ['Música', 'Teatre', 'Cinema', 'Monòlegs', 'Màgia']; // defineixo 5 categories per a la pàgina

        foreach ($categories as $name) {
            Category::create(['name' => $name]);
        }
    }
}
