<?php
// database/migrations/xxxx_xx_xx_create_cajas_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCajasTable extends Migration
{
    public function up()
    {
        Schema::create('cajas', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->unique();
            $table->string('nombre');
            $table->decimal('efectivo', 10, 2);
            $table->enum('estado', ['Habilitada', 'Deshabilitada']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cajas');
    }
}
