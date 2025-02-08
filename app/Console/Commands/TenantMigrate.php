<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Empresa;
use Illuminate\Support\Facades\Artisan;

class TenantMigrate extends Command
{
    protected $signature = 'tenant:migrate {db_name}';
    protected $description = 'Ejecuta migraciones en la base de datos de un tenant';

    public function handle()
    {
        $dbName = $this->argument('db_name');

        config(['database.connections.tenant.database' => $dbName]);

        // Ejecutar migraciones en la base de datos del tenant
        Artisan::call('migrate', ['--database' => 'tenant', '--path' => 'database/migrations']);

        $this->info("Migraciones ejecutadas en la base de datos: {$dbName}");
    }
}

