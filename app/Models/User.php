<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Profile;



use Spatie\Permission\Traits\HasRoles;




class User extends Authenticatable
{


    use HasRoles; // ✅ Agrega esta línea para habilitar roles y permisos

    use HasApiTokens, HasFactory, Notifiable;

    protected $with = ['profile']; // Carga el perfil automáticamente al consultar un usuario

    protected $fillable = [
        'name',
        'email',
        'password',
        'onboarding_completo',
        'empresa_id', // Asegúrate de que 'empresa_id' esté en el fillable
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

    // Relación con el perfil (opcional)
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    // Relación con la empresa
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    // Definición de la conexión dinámica
    public function getConnectionName()
    {
        return 'tenant'; // Cambia 'tenant' si usas otro nombre de conexión
    }
}
