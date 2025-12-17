<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participante;
use App\Models\Premio;

class RifaController extends Controller
{
    public function index()
    {
        // Participantes
        $totalParticipantes = Participante::count();

        // Premios
        $totalPremios = Premio::count();
        $premiosEntregados = Premio::where('entregado', true)->count();
        $premiosFaltantes = Premio::where('entregado', false)->count();

        return view('rifa.index', [
            // 🎰 Ruleta (NO tocar)
            'nombres' => Participante::where('ganador', false)->pluck('nombre'),
            'premios' => Premio::where('entregado', false)->pluck('nombre'),

            // 📊 Estadísticas
            'totalParticipantes' => $totalParticipantes,
            'totalPremios' => $totalPremios,
            'premiosEntregados' => $premiosEntregados,
            'premiosFaltantes' => $premiosFaltantes,
        ]);
    }

    public function estadisticas()
    {
        return response()->json([
            'totalParticipantes' => Participante::count(),
            'totalPremios'       => Premio::count(),
            'premiosEntregados'  => Premio::where('entregado', true)->count(),
            'premiosFaltantes'   => Premio::where('entregado', false)->count(),
        ]);
    }
    

    // 🎰 Girar nombre (NO se marca ganador aún)
    public function girarNombre()
    {
        $participante = Participante::where('seleccionado', false)
            ->inRandomOrder()
            ->first();

        if (!$participante) {
            return response()->json([
                'error' => 'Ya no hay participantes disponibles'
            ], 422);
        }

        // 🟢 ya salió en la ruleta
        $participante->seleccionado = true;
        $participante->ganador = true;
        $participante->save();

        return response()->json([
            'ganador' => $participante->nombre,
            'id' => $participante->id
        ]);
    }


    // 🎁 Girar premio (aquí sí se confirma todo)
    public function girarPremio(Request $request)
    {
        // buscar premio disponible
        $premio = Premio::where('entregado', false)
            ->inRandomOrder()
            ->first();

        // 🚫 No hay premios → fin inmediato
        if (!$premio) {
            return response()->json([
                'fin' => true
            ]);
        }

        // buscar participante
        $participante = Participante::findOrFail($request->participante_id);

        /**
         * ✅ CONFIRMAMOS QUE ASISTIÓ
         * (si no asistió, NO se llama este método,
         * se llama al botón "No asistió")
         */
        $participante->asistio = true;
        $participante->premio_id = $premio->id;
        $participante->save();

        // marcar premio como entregado
        $premio->entregado = true;
        $premio->save();

        // ¿quedan premios?
        $quedanPremios = Premio::where('entregado', false)->exists();

        return response()->json([
            'premio' => $premio->nombre,
            'fin' => !$quedanPremios
        ]);
    }


    public function participantes()
    {
        $participantes = Participante::orderBy('nombre')->get();
        return view('rifa.participantes', compact('participantes'));
    }

    public function estadoRifa()
    {
        $hayPremios = Premio::where('entregado', false)->exists();

        return response()->json([
            'activa' => $hayPremios
        ]);
    }
    public function feed()
    {
        return view('dashboard', [
            'premiosRestantes'   => Premio::where('entregado', false)->count(),
            'personasRestantes' => Participante::where('ganador', false)->count(),
        ]);
    }
    public function noAsistio(Request $request)
    {
        $participante = Participante::findOrFail($request->participante_id);

        $participante->asistio = false;
        $participante->premio_id = null;
        $participante->save();

        return response()->json(['ok' => true]);
    }
    public function ultimosGanadores()
    {
        return Participante::whereNotNull('premio_id')
            ->with('premio')
            ->orderByDesc('updated_at')
            ->take(3)
            ->get()
            ->map(fn ($p) => [
                'nombre' => $p->nombre,
                'premio' => $p->premio->nombre
            ]);
    }



}
