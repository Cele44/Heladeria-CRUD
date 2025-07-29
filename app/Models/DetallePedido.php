<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    /** @use HasFactory<\Database\Factories\DetallePedidoFactory> */
    use HasFactory;

    protected $fillable = [
        'pedido_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
        'subtotal',
        'instrucciones_especiales',
        'promocion_id',
    ];

    // Relación con Pedido
    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    // Relación con Producto (opcional, puede ser nulo si es personalizado)
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    // Relación muchos a muchos con Ingredientes (extras)
    public function ingredientes()
    {
        return $this->belongsToMany(
            Ingrediente::class,
            'detalle_pedido_ingredientes',
            'detalle_id',
            'ingrediente_id'
        )->withPivot('es_extra');
    }
    public function ingredientesPersonalizados()
    {
        return $this->hasMany(DetallePedidoIngrediente::class, 'detalle_id');
    }
    public function promocion()
    {
        return $this->belongsTo(Promocion::class);
    }
}
