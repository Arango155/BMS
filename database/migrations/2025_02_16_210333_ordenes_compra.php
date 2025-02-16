<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('ordenes_compra', function (Blueprint $table) {
            $table->id();
            $table->string('numero_orden')->unique();
            $table->string('proveedor');
            $table->decimal('monto_total', 10, 2);
            $table->date('fecha');
            $table->enum('estado', ['Pendiente', 'Aprobada', 'Cancelada'])->default('Pendiente');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ordenes_compra');
    }
};
