<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('onboarding_completo')->default(false); // Si no existe aún
        });
    }


    public function down() {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('onboarding_completo');
        });
    }
};
