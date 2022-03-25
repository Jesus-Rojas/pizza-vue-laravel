<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngredientePizza extends Model
{
    use HasFactory;

    protected $fillable = [
        'pizzas_id',
        'ingredientes_id',
    ];

    public function ingredientes(){
        return $this->belongsTo(Ingrediente::class);
    }

    public function pizzas(){
        return $this->belongsTo(Pizza::class);
    }
}
