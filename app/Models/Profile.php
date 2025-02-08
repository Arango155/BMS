<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'dashboard_name',
        'empresa_tipo',
        'empresa_nombre',
        'modulos',
        'onboarding_completo',
    ];

    protected $casts = [
        'onboarding_completo' => 'boolean',
    ];

    // Relación con User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con Empresa (si es necesario)
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}
