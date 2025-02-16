<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Compras extends Migration
{
    public function up()
    {
        Schema::connection('tenant')->create('compras', function (Blueprint $table) {
            $table->id();
            $table->string('proveedor');
            $table->decimal('monto', 10, 2);
            $table->date('fecha');
            $table->string('estado');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('tenant')->dropIfExists('compras');
    }
}
