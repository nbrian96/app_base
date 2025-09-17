import { Head, Link, router } from '@inertiajs/react';
import { useState } from 'react';
import AppLayout from '@/layouts/app-layout';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { MoreHorizontal, Plus, Search, Edit, Trash2, Eye, UserCheck, UserX } from 'lucide-react';

interface User {
    id: number;
    name: string;
    email: string;
    role: 'admin' | 'coordinador' | 'alumno';
    is_active: boolean;
    created_at: string;
}

interface UsersIndexProps {
    users: {
        data: User[];
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
        links: any[];
    };
    filters: {
        search?: string;
        role?: string;
        status?: string;
    };
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

export default function UsersIndex({ users, filters }: UsersIndexProps) {
    const [search, setSearch] = useState(filters.search || '');
    const [role, setRole] = useState(filters.role || '');
    const [status, setStatus] = useState(filters.status || '');

    const handleSearch = () => {
        router.get(route('admin.users.index'), {
            search: search || undefined,
            role: role || undefined,
            status: status || undefined,
        }, {
            preserveState: true,
            replace: true,
        });
    };

    const handleToggleStatus = (user: User) => {
        router.patch(route('admin.users.toggle-status', user.id), {}, {
            onSuccess: () => {
                // La página se recargará automáticamente
            },
        });
    };

    const handleDelete = (user: User) => {
        if (confirm('¿Estás seguro de que quieres eliminar este usuario?')) {
            router.delete(route('admin.users.destroy', user.id));
        }
    };

    return (
        <AppLayout>
            <Head title="Gestión de Usuarios" />

            <div className="space-y-6">
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-3xl font-bold tracking-tight">Gestión de Usuarios</h1>
                        <p className="text-muted-foreground">
                            Administra los usuarios del sistema y sus roles
                        </p>
                    </div>
                    <Link href={route('admin.users.create')}>
                        <Button>
                            <Plus className="mr-2 h-4 w-4" />
                            Nuevo Usuario
                        </Button>
                    </Link>
                </div>

                <Card>
                    <CardHeader>
                        <CardTitle>Filtros</CardTitle>
                        <CardDescription>
                            Busca y filtra usuarios por diferentes criterios
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div className="flex flex-col sm:flex-row gap-4">
                            <div className="flex-1">
                                <div className="relative">
                                    <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 text-muted-foreground h-4 w-4" />
                                    <Input
                                        placeholder="Buscar por nombre o email..."
                                        value={search}
                                        onChange={(e) => setSearch(e.target.value)}
                                        className="pl-10"
                                        onKeyPress={(e) => e.key === 'Enter' && handleSearch()}
                                    />
                                </div>
                            </div>
                            <Select value={role} onValueChange={setRole}>
                                <SelectTrigger className="w-full sm:w-[180px]">
                                    <SelectValue placeholder="Todos los roles" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="">Todos los roles</SelectItem>
                                    <SelectItem value="admin">Administrador</SelectItem>
                                    <SelectItem value="coordinador">Coordinador</SelectItem>
                                    <SelectItem value="alumno">Alumno</SelectItem>
                                </SelectContent>
                            </Select>
                            <Select value={status} onValueChange={setStatus}>
                                <SelectTrigger className="w-full sm:w-[180px]">
                                    <SelectValue placeholder="Todos los estados" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="">Todos los estados</SelectItem>
                                    <SelectItem value="active">Activo</SelectItem>
                                    <SelectItem value="inactive">Inactivo</SelectItem>
                                </SelectContent>
                            </Select>
                            <Button onClick={handleSearch} variant="outline">
                                <Search className="mr-2 h-4 w-4" />
                                Buscar
                            </Button>
                        </div>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader>
                        <CardTitle>Usuarios ({users.total})</CardTitle>
                        <CardDescription>
                            Lista de todos los usuarios registrados en el sistema
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div className="rounded-md border">
                            <Table>
                                <TableHeader>
                                    <TableRow>
                                        <TableHead>Nombre</TableHead>
                                        <TableHead>Email</TableHead>
                                        <TableHead>Rol</TableHead>
                                        <TableHead>Estado</TableHead>
                                        <TableHead>Fecha de registro</TableHead>
                                        <TableHead className="w-[70px]">Acciones</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    {users.data.map((user) => (
                                        <TableRow key={user.id}>
                                            <TableCell className="font-medium">
                                                {user.name}
                                            </TableCell>
                                            <TableCell>{user.email}</TableCell>
                                            <TableCell>
                                                <Badge variant={roleColors[user.role]}>
                                                    {roleLabels[user.role]}
                                                </Badge>
                                            </TableCell>
                                            <TableCell>
                                                <Badge variant={user.is_active ? 'default' : 'secondary'}>
                                                    {user.is_active ? 'Activo' : 'Inactivo'}
                                                </Badge>
                                            </TableCell>
                                            <TableCell>
                                                {new Date(user.created_at).toLocaleDateString('es-ES')}
                                            </TableCell>
                                            <TableCell>
                                                <DropdownMenu>
                                                    <DropdownMenuTrigger asChild>
                                                        <Button variant="ghost" className="h-8 w-8 p-0">
                                                            <MoreHorizontal className="h-4 w-4" />
                                                        </Button>
                                                    </DropdownMenuTrigger>
                                                    <DropdownMenuContent align="end">
                                                        <DropdownMenuItem asChild>
                                                            <Link href={route('admin.users.show', user.id)}>
                                                                <Eye className="mr-2 h-4 w-4" />
                                                                Ver
                                                            </Link>
                                                        </DropdownMenuItem>
                                                        <DropdownMenuItem asChild>
                                                            <Link href={route('admin.users.edit', user.id)}>
                                                                <Edit className="mr-2 h-4 w-4" />
                                                                Editar
                                                            </Link>
                                                        </DropdownMenuItem>
                                                        <DropdownMenuItem
                                                            onClick={() => handleToggleStatus(user)}
                                                        >
                                                            {user.is_active ? (
                                                                <>
                                                                    <UserX className="mr-2 h-4 w-4" />
                                                                    Desactivar
                                                                </>
                                                            ) : (
                                                                <>
                                                                    <UserCheck className="mr-2 h-4 w-4" />
                                                                    Activar
                                                                </>
                                                            )}
                                                        </DropdownMenuItem>
                                                        <DropdownMenuItem
                                                            onClick={() => handleDelete(user)}
                                                            className="text-destructive"
                                                        >
                                                            <Trash2 className="mr-2 h-4 w-4" />
                                                            Eliminar
                                                        </DropdownMenuItem>
                                                    </DropdownMenuContent>
                                                </DropdownMenu>
                                            </TableCell>
                                        </TableRow>
                                    ))}
                                </TableBody>
                            </Table>
                        </div>

                        {users.data.length === 0 && (
                            <div className="text-center py-8">
                                <p className="text-muted-foreground">No se encontraron usuarios</p>
                            </div>
                        )}

                        {/* Paginación */}
                        {users.last_page > 1 && (
                            <div className="flex items-center justify-between mt-4">
                                <div className="text-sm text-muted-foreground">
                                    Mostrando {((users.current_page - 1) * users.per_page) + 1} a{' '}
                                    {Math.min(users.current_page * users.per_page, users.total)} de{' '}
                                    {users.total} resultados
                                </div>
                                <div className="flex space-x-2">
                                    {users.links.map((link, index) => (
                                        <Button
                                            key={index}
                                            variant={link.active ? 'default' : 'outline'}
                                            size="sm"
                                            disabled={!link.url}
                                            onClick={() => link.url && router.get(link.url)}
                                        >
                                            <span dangerouslySetInnerHTML={{ __html: link.label }} />
                                        </Button>
                                    ))}
                                </div>
                            </div>
                        )}
                    </CardContent>
                </Card>
            </div>
        </AppLayout>
    );
}
