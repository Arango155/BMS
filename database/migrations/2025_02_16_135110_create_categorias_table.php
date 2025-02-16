<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->string('ubicacion')->nullable();
            $table->string('estado')->default('Habilitado'); // 'Habilitado' o 'No Habilitado'
            $table->integer('productos')->default(0); // Número de productos en la categoría
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('categorias');
    }
};
