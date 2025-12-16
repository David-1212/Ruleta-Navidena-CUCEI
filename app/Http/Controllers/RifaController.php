<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participante;
use App\Models\Premio;

class RifaController extends Controller
{
    public function index()
    {
        return view('rifa.index', [
            'nombres' => Participante::where('ganador', false)->pluck('nombre'),
            'premios' => Premio::where('entregado', false)->pluck('nombre')
        ]);
    }

    // 🎰 Girar nombre (NO se marca ganador aún)
    public function girarNombre()
    {
        $participante = Participante::where('ganador', false)
            ->inRandomOrder()
            ->first();

        if (!$participante) {
            return response()->json([
                'fin' => true
            ]);
        }

        return response()->json([
            'ganador' => $participante->nombre,
            'id' => $participante->id
        ]);
    }

    // 🎁 Girar premio (aquí sí se confirma todo)
    public function girarPremio(Request $request)
    {
        $premio = Premio::where('entregado', false)
            ->inRandomOrder()
            ->first();

        // 🚫 No hay premios → fin inmediato
        if (!$premio) {
            return response()->json([
                'fin' => true
            ]);
        }

        // marcar premio como entregado
        $premio->entregado = true;
        $premio->save();

        // marcar participante como ganador
        $participante = Participante::find($request->participante_id);
        if ($participante) {
            $participante->ganador = true;
            $participante->save();
        }

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

}
