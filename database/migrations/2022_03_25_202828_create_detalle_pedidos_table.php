<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('detalle_pedidos', function (Blueprint $table) {
            $table->id();
            $table->integer('cantidad');
            $table->integer('precio_unitario');

            // foraneas
            $table->foreignId('pizzas_id')
                ->references('pizzas')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('pedidos_id')
                ->references('pedidos')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('detalle_pedidos');
    }
};
