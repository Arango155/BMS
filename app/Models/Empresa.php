<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'db_name'];

    // Relación con usuarios
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Método para obtener la conexión correcta
    public function getConnectionName()
    {
        return 'tenant'; // Asegúrate de que 'tenant' es la conexión correcta
    }
}
