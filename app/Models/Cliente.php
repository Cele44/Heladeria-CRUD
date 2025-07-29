<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Cliente extends Authenticatable
{
    use Notifiable;
    use HasFactory, Notifiable;

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'telefono',
        'direccion',
        'password_hash',
        'activo',
    ];

    protected $hidden = [
        'password_hash',
    ];
    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    // Relaciones
    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'cliente_id');
    }

    public function fidelizacion()
    {
        return $this->hasOne(Fidelizacion::class, 'cliente_id');
    }

    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class, 'cliente_id');
    }
}
