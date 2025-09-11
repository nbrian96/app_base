<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CheckRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roles:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verificar roles y permisos del sistema';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== VERIFICACIÓN DE ROLES Y PERMISOS ===');
        $this->newLine();

        // Mostrar roles creados
        $this->info('📋 Roles creados:');
        $roles = Role::all();
        foreach ($roles as $role) {
            $this->line("  • {$role->name} ({$role->permissions->count()} permisos)");
        }
        $this->newLine();

        // Mostrar usuarios con roles
        $this->info('👥 Usuarios con roles:');
        $users = User::with('roles')->get();
        foreach ($users as $user) {
            $userRoles = $user->roles->pluck('name')->join(', ');
            $this->line("  • {$user->name} ({$user->email}) - Roles: {$userRoles}");
        }
        $this->newLine();

        // Mostrar estadísticas
        $this->info('📊 Estadísticas:');
        $this->line("  • Total de roles: {$roles->count()}");
        $this->line("  • Total de permisos: " . Permission::count());
        $this->line("  • Total de usuarios: {$users->count()}");
        $this->newLine();

        $this->info('✅ Verificación completada exitosamente');
    }
}