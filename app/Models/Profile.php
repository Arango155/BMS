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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
