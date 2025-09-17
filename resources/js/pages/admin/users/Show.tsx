import { Head, Link } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { ArrowLeft, Edit, User, Mail, Shield, Calendar, CheckCircle, XCircle } from 'lucide-react';

interface User {
    id: number;
    name: string;
    email: string;
    role: 'admin' | 'coordinador' | 'alumno';
    is_active: boolean;
    created_at: string;
    updated_at: string;
}

interface ShowUserProps {
    user: User;
}

const roleLabels = {
    admin: 'Administrador',
    coordinador: 'Coordinador',
    alumno: 'Alumno',
};

const roleColors = {
    admin: 'destructive',
    coordinador: 'default',
    alumno: 'secondary',
} as const;

export default function ShowUser({ user }: ShowUserProps) {
    return (
        <AppLayout>
            <Head title={`Usuario: ${user.name}`} />

            <div className="space-y-6">
                <div className="flex items-center justify-between">
                    <div className="flex items-center space-x-4">
                        <Link href={route('admin.users.index')}>
                            <Button variant="outline" size="sm">
                                <ArrowLeft className="mr-2 h-4 w-4" />
                                Volver
                            </Button>
                        </Link>
                        <div>
                            <h1 className="text-3xl font-bold tracking-tight">{user.name}</h1>
                            <p className="text-muted-foreground">
                                Información detallada del usuario
                            </p>
                        </div>
                    </div>
                    <Link href={route('admin.users.edit', user.id)}>
                        <Button>
                            <Edit className="mr-2 h-4 w-4" />
                            Editar Usuario
                        </Button>
                    </Link>
                </div>

                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <Card>
                        <CardHeader>
                            <CardTitle className="flex items-center">
                                <User className="mr-2 h-5 w-5" />
                                Información Personal
                            </CardTitle>
                            <CardDescription>
                                Datos básicos del usuario
                            </CardDescription>
                        </CardHeader>
                        <CardContent className="space-y-4">
                            <div>
                                <label className="text-sm font-medium text-muted-foreground">
                                    Nombre completo
                                </label>
                                <p className="text-sm">{user.name}</p>
                            </div>
                            <div>
                                <label className="text-sm font-medium text-muted-foreground">
                                    Email
                                </label>
                                <p className="text-sm flex items-center">
                                    <Mail className="mr-2 h-4 w-4" />
                                    {user.email}
                                </p>
                            </div>
                            <div>
                                <label className="text-sm font-medium text-muted-foreground">
                                    Estado
                                </label>
                                <div className="flex items-center mt-1">
                                    {user.is_active ? (
                                        <CheckCircle className="mr-2 h-4 w-4 text-green-500" />
                                    ) : (
                                        <XCircle className="mr-2 h-4 w-4 text-red-500" />
                                    )}
                                    <Badge variant={user.is_active ? 'default' : 'secondary'}>
                                        {user.is_active ? 'Activo' : 'Inactivo'}
                                    </Badge>
                                </div>
                            </div>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader>
                            <CardTitle className="flex items-center">
                                <Shield className="mr-2 h-5 w-5" />
                                Información del Sistema
                            </CardTitle>
                            <CardDescription>
                                Configuración y permisos del usuario
                            </CardDescription>
                        </CardHeader>
                        <CardContent className="space-y-4">
                            <div>
                                <label className="text-sm font-medium text-muted-foreground">
                                    Rol
                                </label>
                                <div className="mt-1">
                                    <Badge variant={roleColors[user.role]}>
                                        {roleLabels[user.role]}
                                    </Badge>
                                </div>
                            </div>
                            <div>
                                <label className="text-sm font-medium text-muted-foreground">
                                    ID del Usuario
                                </label>
                                <p className="text-sm font-mono">#{user.id}</p>
                            </div>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader>
                            <CardTitle className="flex items-center">
                                <Calendar className="mr-2 h-5 w-5" />
                                Fechas
                            </CardTitle>
                            <CardDescription>
                                Información temporal del usuario
                            </CardDescription>
                        </CardHeader>
                        <CardContent className="space-y-4">
                            <div>
                                <label className="text-sm font-medium text-muted-foreground">
                                    Fecha de registro
                                </label>
                                <p className="text-sm">
                                    {new Date(user.created_at).toLocaleDateString('es-ES', {
                                        year: 'numeric',
                                        month: 'long',
                                        day: 'numeric',
                                        hour: '2-digit',
                                        minute: '2-digit',
                                    })}
                                </p>
                            </div>
                            <div>
                                <label className="text-sm font-medium text-muted-foreground">
                                    Última actualización
                                </label>
                                <p className="text-sm">
                                    {new Date(user.updated_at).toLocaleDateString('es-ES', {
                                        year: 'numeric',
                                        month: 'long',
                                        day: 'numeric',
                                        hour: '2-digit',
                                        minute: '2-digit',
                                    })}
                                </p>
                            </div>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader>
                            <CardTitle>Permisos del Rol</CardTitle>
                            <CardDescription>
                                Permisos asociados al rol {roleLabels[user.role]}
                            </CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div className="space-y-2">
                                {user.role === 'admin' && (
                                    <>
                                        <div className="flex items-center text-sm">
                                            <CheckCircle className="mr-2 h-4 w-4 text-green-500" />
                                            Acceso completo al sistema
                                        </div>
                                        <div className="flex items-center text-sm">
                                            <CheckCircle className="mr-2 h-4 w-4 text-green-500" />
                                            Gestión de usuarios
                                        </div>
                                        <div className="flex items-center text-sm">
                                            <CheckCircle className="mr-2 h-4 w-4 text-green-500" />
                                            Gestión de carreras y materias
                                        </div>
                                        <div className="flex items-center text-sm">
                                            <CheckCircle className="mr-2 h-4 w-4 text-green-500" />
                                            Gestión de estudiantes
                                        </div>
                                        <div className="flex items-center text-sm">
                                            <CheckCircle className="mr-2 h-4 w-4 text-green-500" />
                                            Gestión de calificaciones
                                        </div>
                                        <div className="flex items-center text-sm">
                                            <CheckCircle className="mr-2 h-4 w-4 text-green-500" />
                                            Generación de reportes
                                        </div>
                                    </>
                                )}
                                {user.role === 'coordinador' && (
                                    <>
                                        <div className="flex items-center text-sm">
                                            <CheckCircle className="mr-2 h-4 w-4 text-green-500" />
                                            Gestión de carreras y materias
                                        </div>
                                        <div className="flex items-center text-sm">
                                            <CheckCircle className="mr-2 h-4 w-4 text-green-500" />
                                            Gestión de estudiantes
                                        </div>
                                        <div className="flex items-center text-sm">
                                            <CheckCircle className="mr-2 h-4 w-4 text-green-500" />
                                            Gestión de calificaciones
                                        </div>
                                        <div className="flex items-center text-sm">
                                            <CheckCircle className="mr-2 h-4 w-4 text-green-500" />
                                            Generación de reportes
                                        </div>
                                        <div className="flex items-center text-sm">
                                            <XCircle className="mr-2 h-4 w-4 text-red-500" />
                                            Gestión de usuarios
                                        </div>
                                    </>
                                )}
                                {user.role === 'alumno' && (
                                    <>
                                        <div className="flex items-center text-sm">
                                            <CheckCircle className="mr-2 h-4 w-4 text-green-500" />
                                            Ver información personal
                                        </div>
                                        <div className="flex items-center text-sm">
                                            <CheckCircle className="mr-2 h-4 w-4 text-green-500" />
                                            Ver calificaciones
                                        </div>
                                        <div className="flex items-center text-sm">
                                            <CheckCircle className="mr-2 h-4 w-4 text-green-500" />
                                            Acceso al dashboard
                                        </div>
                                        <div className="flex items-center text-sm">
                                            <XCircle className="mr-2 h-4 w-4 text-red-500" />
                                            Gestión de usuarios
                                        </div>
                                        <div className="flex items-center text-sm">
                                            <XCircle className="mr-2 h-4 w-4 text-red-500" />
                                            Gestión de carreras
                                        </div>
                                        <div className="flex items-center text-sm">
                                            <XCircle className="mr-2 h-4 w-4 text-red-500" />
                                            Gestión de calificaciones
                                        </div>
                                    </>
                                )}
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </AppLayout>
    );
}
