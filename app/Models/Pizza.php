<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pizza extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'precio',
        'imagen',
        'stock',
    ];

    public function detalle_pedidos(){
        return $this->hasMany(DetallePedido::class,'pizzas_id');
    }

    public function ingrediente_pizzas(){
        return $this->hasMany(IngredientePizza::class,'pizzas_id');
    }
}
