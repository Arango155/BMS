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
        'modulos', // Se almacena como JSON
        'onboarding_completo',
    ];

    protected $casts = [
        'modulos' => 'array', // Laravel convertirá automáticamente el JSON a un array
        'onboarding_completo' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
