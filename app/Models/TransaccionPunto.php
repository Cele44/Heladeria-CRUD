<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaccionPunto extends Model
{
    /** @use HasFactory<\Database\Factories\TransaccionPuntoFactory> */
    use HasFactory;
    protected $table = 'transacciones_puntos';

    protected $fillable = [
        'fidelizacion_id',
        'puntos',
        'tipo',
        'motivo',
        'pedido_id',
    ];

    // Relación con Fidelización
    public function fidelizacion()
    {
        return $this->belongsTo(Fidelizacion::class, 'fidelizacion_id');
    }

    // Relación con Pedido (opcional)
    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'pedido_id');
    }
}
