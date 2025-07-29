<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fidelizacion extends Model
{
    /** @use HasFactory<\Database\Factories\FidelizacionFactory> */
    use HasFactory;
    protected $table = 'fidelizacion';

    protected $fillable = [
        'cliente_id',
        'puntos_acumulados',
        'nivel',
    ];

    // Relación con Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    // Relación con TransaccionesPuntos
    public function transacciones()
    {
        return $this->hasMany(TransaccionPunto::class, 'fidelizacion_id');
    }
}
