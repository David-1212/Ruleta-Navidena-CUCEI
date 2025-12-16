<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participante;

class ParticipanteController extends Controller
{
    public function index(Request $request)
    {
        $query = Participante::query();
    
        if ($request->estado === 'ganador') {
            $query->where('ganador', true);
        }
    
        if ($request->estado === 'no_ganador') {
            $query->where('ganador', false);
        }
    
        $participantes = $query
            ->orderBy('nombre')
            ->paginate(20)
            ->withQueryString(); // mantiene filtros en la paginación
    
        return view('participantes.index', compact('participantes'));
    }

    public function importar(Request $request)
    {
        $request->validate([
            'archivo' => 'required|file|mimes:csv,txt'
        ]);

        $archivo = fopen($request->file('archivo'), 'r');

        while (($linea = fgetcsv($archivo, 1000, ',')) !== false) {
            if (!empty($linea[0])) {
                Participante::create([
                    'nombre' => $linea[0],
                    'ganador' => false
                ]);
            }
        }

        fclose($archivo);

        return back()->with('success', 'Participantes importados correctamente');
    }

    public function buscar(Request $request)
{
    $query = Participante::query();

    if ($request->filled('buscar')) {
        $query->where('nombre', 'like', '%' . $request->buscar . '%');
    }

    $participantes = $query
        ->orderBy('nombre')
        ->paginate(20)
        ->withQueryString();

    return view('participantes._tabla', compact('participantes'));
}


}
