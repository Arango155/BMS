<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryProduct extends Model
{
    use HasFactory;

    protected $table = 'inventory_products'; // 🔥 Asegurar que usa la tabla correcta

    protected $fillable = [
        'code', 'sku', 'name', 'stock', 'min_stock', 'presentation',
        'purchase_price', 'sale_price', 'wholesale_price', 'discount',
        'brand', 'model', 'expires', 'expiration_date', 'factory_warranty',
        'warranty_unit', 'warranty_time', 'status', 'sold_quantity'
    ];
}
