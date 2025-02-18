<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('inventory_products', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('sku')->nullable();
            $table->string('name');
            $table->integer('stock');
            $table->integer('min_stock');
            $table->string('presentation');
            $table->decimal('purchase_price', 10, 2);
            $table->decimal('sale_price', 10, 2);
            $table->decimal('wholesale_price', 10, 2)->nullable();
            $table->integer('discount')->default(0);
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->enum('expires', ['Yes', 'No'])->default('No');
            $table->date('expiration_date')->nullable();
            $table->enum('factory_warranty', ['Yes', 'No'])->default('No');
            $table->string('warranty_unit')->nullable();
            $table->integer('warranty_time')->nullable();
            $table->enum('status', ['Enabled', 'Disabled'])->default('Enabled');
            $table->integer('sold_quantity')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('inventory_products');
    }
};
