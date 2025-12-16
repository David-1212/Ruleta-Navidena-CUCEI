<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'usuarios' => User::all(),
            'premios' => Premio::all(),
            'participantes' => Participante::all()
        ]);
    }

}
