<?php

namespace App\Http\Controllers;

use App\Models\Premio;
use App\Models\Participante;

class DashboardController extends Controller
{
    public function index()
    {
        // Premios
        $totalPremios = Premio::count();
        $premiosRestantes = Premio::where('entregado', false)->count();

        // Participantes
        $totalParticipantes = Participante::count();
        $personasRestantes = Participante::where('ganador', false)->count();

        return view('dashboard', compact(
            'totalPremios',
            'premiosRestantes',
            'totalParticipantes',
            'personasRestantes'
        ));
    }
}
