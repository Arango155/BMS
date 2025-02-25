<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo_documento', 'documento', 'nombres', 'apellidos',
        'estado_residencia', 'ciudad', 'direccion', 'telefono', 'email'
    ];
}
