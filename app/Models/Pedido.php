<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'venta_total',
        'users_id',
    ];

    public function users(){
        return $this->belongsTo(User::class);
    }

    public function detalle_pedidos(){
        return $this->hasMany(DetallePedido::class,'pedidos_id');
    }
}
