<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear permisos
        $permissions = [
            // Gestión de usuarios
            ['name' => 'Ver usuarios', 'slug' => 'users.view', 'module' => 'usuarios'],
            ['name' => 'Crear usuarios', 'slug' => 'users.create', 'module' => 'usuarios'],
            ['name' => 'Editar usuarios', 'slug' => 'users.edit', 'module' => 'usuarios'],
            ['name' => 'Eliminar usuarios', 'slug' => 'users.delete', 'module' => 'usuarios'],
            
            // Gestión de carreras
            ['name' => 'Ver carreras', 'slug' => 'careers.view', 'module' => 'carreras'],
            ['name' => 'Crear carreras', 'slug' => 'careers.create', 'module' => 'carreras'],
            ['name' => 'Editar carreras', 'slug' => 'careers.edit', 'module' => 'carreras'],
            ['name' => 'Eliminar carreras', 'slug' => 'careers.delete', 'module' => 'carreras'],
            
            // Gestión de materias
            ['name' => 'Ver materias', 'slug' => 'subjects.view', 'module' => 'materias'],
            ['name' => 'Crear materias', 'slug' => 'subjects.create', 'module' => 'materias'],
            ['name' => 'Editar materias', 'slug' => 'subjects.edit', 'module' => 'materias'],
            ['name' => 'Eliminar materias', 'slug' => 'subjects.delete', 'module' => 'materias'],
            
            // Gestión de estudiantes
            ['name' => 'Ver estudiantes', 'slug' => 'students.view', 'module' => 'estudiantes'],
            ['name' => 'Crear estudiantes', 'slug' => 'students.create', 'module' => 'estudiantes'],
            ['name' => 'Editar estudiantes', 'slug' => 'students.edit', 'module' => 'estudiantes'],
            ['name' => 'Eliminar estudiantes', 'slug' => 'students.delete', 'module' => 'estudiantes'],
            
            // Gestión de calificaciones
            ['name' => 'Ver calificaciones', 'slug' => 'grades.view', 'module' => 'calificaciones'],
            ['name' => 'Crear calificaciones', 'slug' => 'grades.create', 'module' => 'calificaciones'],
            ['name' => 'Editar calificaciones', 'slug' => 'grades.edit', 'module' => 'calificaciones'],
            ['name' => 'Eliminar calificaciones', 'slug' => 'grades.delete', 'module' => 'calificaciones'],
            
            // Reportes
            ['name' => 'Ver reportes', 'slug' => 'reports.view', 'module' => 'reportes'],
            ['name' => 'Generar reportes', 'slug' => 'reports.generate', 'module' => 'reportes'],
            
            // Dashboard
            ['name' => 'Ver dashboard', 'slug' => 'dashboard.view', 'module' => 'dashboard'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['slug' => $permission['slug']],
                $permission
            );
        }

        // Crear roles
        $adminRole = Role::updateOrCreate(
            ['slug' => 'admin'],
            [
                'name' => 'Administrador',
                'description' => 'Acceso completo al sistema',
            ]
        );

        $coordinadorRole = Role::updateOrCreate(
            ['slug' => 'coordinador'],
            [
                'name' => 'Coordinador',
                'description' => 'Gestión académica y de estudiantes',
            ]
        );

        $alumnoRole = Role::updateOrCreate(
            ['slug' => 'alumno'],
            [
                'name' => 'Alumno',
                'description' => 'Acceso a información personal y académica',
            ]
        );

        // Asignar permisos a roles
        // Admin: todos los permisos
        $adminRole->permissions()->sync(Permission::all());

        // Coordinador: gestión académica
        $coordinadorPermissions = Permission::whereIn('slug', [
            'careers.view', 'careers.create', 'careers.edit',
            'subjects.view', 'subjects.create', 'subjects.edit',
            'students.view', 'students.create', 'students.edit',
            'grades.view', 'grades.create', 'grades.edit',
            'reports.view', 'reports.generate',
            'dashboard.view'
        ])->get();
        $coordinadorRole->permissions()->sync($coordinadorPermissions);

        // Alumno: solo lectura de su información
        $alumnoPermissions = Permission::whereIn('slug', [
            'students.view', 'grades.view', 'dashboard.view'
        ])->get();
        $alumnoRole->permissions()->sync($alumnoPermissions);
    }
}
