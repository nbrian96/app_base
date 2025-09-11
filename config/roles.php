<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Roles del Sistema
    |--------------------------------------------------------------------------
    |
    | Definición de los roles principales del sistema E-Commerce Suite Pro
    |
    */

    'roles' => [
        'admin' => [
            'name' => 'Administrador',
            'description' => 'Acceso completo al sistema',
            'permissions' => 'all', // Todos los permisos
        ],
        'manager' => [
            'name' => 'Manager',
            'description' => 'Gestión operativa completa',
            'permissions' => [
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
            ],
        ],
        'vendedor' => [
            'name' => 'Vendedor',
            'description' => 'Gestión de ventas y CRM',
            'permissions' => [
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
            ],
        ],
        'cliente' => [
            'name' => 'Cliente',
            'description' => 'Acceso limitado al frontend',
            'permissions' => [
                'view-products', 'view-categories', 'view-services',
                'view-cart', 'manage-checkout',
                'view-reservations', 'create-reservations', 'edit-reservations',
                'view-availability',
                'view-customers', 'edit-customers', 'view-customer-history',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Permisos del Sistema
    |--------------------------------------------------------------------------
    |
    | Definición de todos los permisos disponibles en el sistema
    |
    */

    'permissions' => [
        // Dashboard
        'dashboard' => [
            'view-dashboard',
        ],

        // Gestión de Usuarios
        'users' => [
            'view-users',
            'create-users',
            'edit-users',
            'delete-users',
        ],

        // Gestión de Roles y Permisos
        'roles' => [
            'view-roles',
            'create-roles',
            'edit-roles',
            'delete-roles',
            'assign-roles',
        ],

        // Gestión de Catálogo
        'catalog' => [
            'view-products',
            'create-products',
            'edit-products',
            'delete-products',
            'view-categories',
            'create-categories',
            'edit-categories',
            'delete-categories',
        ],

        // Gestión de Servicios
        'services' => [
            'view-services',
            'create-services',
            'edit-services',
            'delete-services',
        ],

        // E-commerce
        'ecommerce' => [
            'view-orders',
            'create-orders',
            'edit-orders',
            'delete-orders',
            'process-orders',
            'view-cart',
            'manage-checkout',
        ],

        // Sistema de Reservas
        'reservations' => [
            'view-reservations',
            'create-reservations',
            'edit-reservations',
            'delete-reservations',
            'manage-calendar',
            'view-availability',
        ],

        // CRM - Clientes
        'crm_customers' => [
            'view-customers',
            'create-customers',
            'edit-customers',
            'delete-customers',
            'view-customer-history',
        ],

        // CRM - Leads y Oportunidades
        'crm_sales' => [
            'view-leads',
            'create-leads',
            'edit-leads',
            'delete-leads',
            'view-opportunities',
            'create-opportunities',
            'edit-opportunities',
            'delete-opportunities',
            'manage-pipeline',
        ],

        // Inventario
        'inventory' => [
            'view-inventory',
            'manage-inventory',
            'view-stock-alerts',
            'manage-suppliers',
        ],

        // Reportes
        'reports' => [
            'view-reports',
            'export-reports',
            'view-analytics',
        ],

        // Configuración
        'settings' => [
            'view-settings',
            'edit-settings',
            'manage-notifications',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Configuración de Middleware
    |--------------------------------------------------------------------------
    |
    | Configuración para el uso de middleware de roles y permisos
    |
    */

    'middleware' => [
        'role' => 'role',
        'permission' => 'permission',
    ],
];
