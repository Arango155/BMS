<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenCompra extends Model
{
    use HasFactory;

    protected $table = 'ordenes_compra';
    protected $fillable = ['numero_orden', 'proveedor', 'monto_total', 'fecha', 'estado'];
}
