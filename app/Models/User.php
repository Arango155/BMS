<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Profile;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $with = ['profile']; // Carga el perfil automáticamente al consultar un usuario

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'onboarding_completo',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'onboarding_completo' => 'boolean',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
