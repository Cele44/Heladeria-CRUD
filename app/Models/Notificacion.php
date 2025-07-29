<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    /** @use HasFactory<\Database\Factories\NotificacionFactory> */
    use HasFactory;
    protected $table = 'notificaciones';
    protected $primaryKey = 'notificacion_id';

    protected $fillable = [
        'cliente_id',
        'titulo',
        'mensaje',
        'tipo',
        'leida',
    ];

    // Relación con Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
