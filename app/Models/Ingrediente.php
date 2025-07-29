<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingrediente extends Model
{
    use HasFactory;
    protected $table = 'ingredientes';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio_extra',
        'disponible',
        'tipo',
        'imagen_url',
    ];

    // Relación muchos a muchos con Productos
    public function productos()
    {
        return $this->belongsToMany(
            Producto::class,
            'producto_ingrediente',
            'ingrediente_id',
            'producto_id'
        )->withPivot('es_default');
    }
}
