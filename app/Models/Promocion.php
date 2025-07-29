<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promocion extends Model
{
    /** @use HasFactory<\Database\Factories\PromocionFactory> */
    use HasFactory;
    protected $table = 'promociones';

    protected $fillable = [
        'nombre',
        'descripcion',
        'tipo',
        'descuento_porcentaje',
        'descuento_monto',
        'fecha_inicio',
        'fecha_fin',
        'dias_aplicables',
        'combo_detalle',
        'activa',
    ];
}
