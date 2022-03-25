<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingrediente extends Model
{
    use HasFactory;

    protected $fillable = ['nombre'];

    public function ingrediente_pizzas(){
        return $this->hasMany(IngredientePizza::class,'ingredientes_id');
    }
}
