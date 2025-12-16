<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Participante;

class ParticipantesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    Participante::insert([
        ['nombre' => 'David'],
        ['nombre' => 'María'],
        ['nombre' => 'Luis'],
        ['nombre' => 'Ana'],
        ['nombre' => 'Carlos'],
    ]);
}
}
