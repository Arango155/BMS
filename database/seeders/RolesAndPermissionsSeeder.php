<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // 📌 Definir Permisos
        $permissions = [
            'ver usuarios',
            'crear usuarios',
            'editar usuarios',
            'eliminar usuarios',
            'ver productos',
            'crear productos',
            'editar productos',
            'eliminar productos'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 📌 Crear Roles y asignar permisos
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $empleado = Role::firstOrCreate(['name' => 'empleado']);

        $admin->givePermissionTo(Permission::all()); // Admin tiene todos los permisos
        $empleado->givePermissionTo(['ver productos']); // Empleado solo puede ver productos
    }
}
