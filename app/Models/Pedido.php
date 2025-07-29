<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    /** @use HasFactory<\Database\Factories\PedidoFactory> */
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'promocion_id',
        'fecha_pedido',
        'estado',
        'total',
        'direccion_entrega',
        'metodo_pago',
        'notas',
    ];

    protected $casts = [
        'fecha_pedido' => 'datetime',
    ];
    // Relación con Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
    public function promocion()
    {
        return $this->belongsTo(Promocion::class);
    }

    // Relación con DetallePedidos
    public function detalles()
    {
        return $this->hasMany(DetallePedido::class, 'pedido_id');
    }
}
