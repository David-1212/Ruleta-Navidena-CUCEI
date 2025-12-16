<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Premio;

class PremiosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Premio::insert([
            ['nombre' => 'TV'],
            ['nombre' => 'Laptop'],
            ['nombre' => 'Audífonos'],
            ['nombre' => 'Smartwatch'],
            ['nombre' => 'Cafetera'],
        ]);
    }
}
