<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Ejecutar el seeder de roles y permisos.
     */
    public function run(): void
    {
        // Crear permisos del sistema
        $permissions = [
            // Dashboard
            'view-dashboard',
            
            // Gestión de Usuarios
            'view-users',
            'create-users',
            'edit-users',
            'delete-users',
            
            // Gestión de Roles y Permisos
            'view-roles',
            'create-roles',
            'edit-roles',
            'delete-roles',
            'assign-roles',
            
            // Gestión de Catálogo
            'view-products',
            'create-products',
            'edit-products',
            'delete-products',
            'view-categories',
            'create-categories',
            'edit-categories',
            'delete-categories',
            
            // Gestión de Servicios
            'view-services',
            'create-services',
            'edit-services',
            'delete-services',
            
            // E-commerce
            'view-orders',
            'create-orders',
            'edit-orders',
            'delete-orders',
            'process-orders',
            'view-cart',
            'manage-checkout',
            
            // Sistema de Reservas
            'view-reservations',
            'create-reservations',
            'edit-reservations',
            'delete-reservations',
            'manage-calendar',
            'view-availability',
            
            // CRM - Clientes
            'view-customers',
            'create-customers',
            'edit-customers',
            'delete-customers',
            'view-customer-history',
            
            // CRM - Leads y Oportunidades
            'view-leads',
            'create-leads',
            'edit-leads',
            'delete-leads',
            'view-opportunities',
            'create-opportunities',
            'edit-opportunities',
            'delete-opportunities',
            'manage-pipeline',
            
            // Inventario
            'view-inventory',
            'manage-inventory',
            'view-stock-alerts',
            'manage-suppliers',
            
            // Reportes
            'view-reports',
            'export-reports',
            'view-analytics',
            
            // Configuración
            'view-settings',
            'edit-settings',
            'manage-notifications',
        ];

        // Crear permisos
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Crear roles y asignar permisos
        
        // 1. ADMIN - Acceso completo al sistema
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        // 2. MANAGER - Gestión operativa completa
        $managerRole = Role::firstOrCreate(['name' => 'manager']);
        $managerPermissions = [
            'view-dashboard',
            'view-users', 'create-users', 'edit-users',
            'view-products', 'create-products', 'edit-products', 'delete-products',
            'view-categories', 'create-categories', 'edit-categories', 'delete-categories',
            'view-services', 'create-services', 'edit-services', 'delete-services',
            'view-orders', 'edit-orders', 'process-orders',
            'view-reservations', 'create-reservations', 'edit-reservations', 'delete-reservations',
            'manage-calendar', 'view-availability',
            'view-customers', 'create-customers', 'edit-customers', 'view-customer-history',
            'view-leads', 'create-leads', 'edit-leads', 'delete-leads',
            'view-opportunities', 'create-opportunities', 'edit-opportunities', 'delete-opportunities',
            'manage-pipeline',
            'view-inventory', 'manage-inventory', 'view-stock-alerts',
            'view-reports', 'export-reports', 'view-analytics',
            'view-settings', 'edit-settings', 'manage-notifications',
        ];
        $managerRole->givePermissionTo($managerPermissions);

        // 3. VENDEDOR - Gestión de ventas y CRM
        $vendedorRole = Role::firstOrCreate(['name' => 'vendedor']);
        $vendedorPermissions = [
            'view-dashboard',
            'view-products', 'view-categories',
            'view-services',
            'view-orders', 'create-orders', 'edit-orders',
            'view-reservations', 'create-reservations', 'edit-reservations',
            'view-availability',
            'view-customers', 'create-customers', 'edit-customers', 'view-customer-history',
            'view-leads', 'create-leads', 'edit-leads',
            'view-opportunities', 'create-opportunities', 'edit-opportunities',
            'manage-pipeline',
            'view-inventory',
            'view-reports', 'export-reports',
        ];
        $vendedorRole->givePermissionTo($vendedorPermissions);

        // 4. CLIENTE - Acceso limitado al frontend
        $clienteRole = Role::firstOrCreate(['name' => 'cliente']);
        $clientePermissions = [
            'view-products', 'view-categories', 'view-services',
            'view-cart', 'manage-checkout',
            'view-reservations', 'create-reservations', 'edit-reservations',
            'view-availability',
            'view-customers', 'edit-customers', 'view-customer-history',
        ];
        $clienteRole->givePermissionTo($clientePermissions);

        $this->command->info('Roles y permisos creados exitosamente:');
        $this->command->info('- Admin: Acceso completo al sistema');
        $this->command->info('- Manager: Gestión operativa completa');
        $this->command->info('- Vendedor: Gestión de ventas y CRM');
        $this->command->info('- Cliente: Acceso limitado al frontend');
    }
}