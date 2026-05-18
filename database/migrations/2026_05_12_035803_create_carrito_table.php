<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        Schema::create('carrito', function (Blueprint $table) {

            $table->id();

            $table->integer('Id_Usuario');

            $table->integer('Id_Producto');

            $table->integer('Cantidad')->default(1);

            $table->decimal('Subtotal', 10, 2);

            $table->timestamps();

        });

    }

    public function down(): void
    {

        Schema::dropIfExists('carrito');

    }
};