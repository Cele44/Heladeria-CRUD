<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePedidoIngrediente extends Model
{
    /** @use HasFactory<\Database\Factories\DetallePedidoIngredienteFactory> */
    use HasFactory;
    protected $table = 'detalle_pedido_ingredientes';
    
    // No usamos $primaryKey porque es una tabla pivote sin clave primaria única
    // protected $primaryKey = ['detalle_id', 'ingrediente_id'];

    protected $fillable = [
        'detalle_id',
        'ingrediente_id',
        'es_extra',
    ];

    // Relación con DetallePedido
    public function detallePedido()
    {
        return $this->belongsTo(DetallePedido::class);
    }

    // Relación con Ingrediente
    public function ingrediente()
    {
        return $this->belongsTo(Ingrediente::class);
    }
}
