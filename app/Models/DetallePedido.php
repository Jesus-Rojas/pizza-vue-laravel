<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'cantidad',
        'precio_unitario',
        'pedidos_id',
        'pizzas_id',
    ];

    public function pedidos(){
        return $this->belongsTo(Pedido::class);
    }

    public function pizzas(){
        return $this->belongsTo(Pizza::class);
    }
}
