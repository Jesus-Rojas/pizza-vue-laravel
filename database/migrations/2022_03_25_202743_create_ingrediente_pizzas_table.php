<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ingrediente_pizzas', function (Blueprint $table) {
            $table->id();
            
            // foraneas
            $table->foreignId('pizzas_id')
                ->references('pizzas')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('ingredientes_id')
                ->references('ingredientes')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ingrediente_pizzas');
    }
};
