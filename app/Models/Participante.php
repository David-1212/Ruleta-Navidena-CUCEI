<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participante extends Model
{
    protected $fillable = [
        'nombre',
        'ganador',
        'premio_id',
        'seleccionado',  
        'asistio',        
    ];

    protected $casts = [
        'ganador' => 'boolean',
        'seleccionado' => 'boolean',
        'asistio' => 'boolean',
    ];

    public function premio()
    {
        return $this->belongsTo(Premio::class);
    }
}

