# Proyecto Base Software Factory 🚀

**Admin Panel + SaaS Starter con Inertia + Vue**

Este documento funciona como **manual de equipo** para entender la arquitectura, módulos, buenas prácticas y ejemplos de cómo trabajar con este proyecto base.

---

## 1. Arquitectura General

El proyecto se divide en dos grandes bloques:

### 1.1 Backend (Laravel 12)

* **Autenticación y Roles:** Laravel Breeze + Inertia (Vue) y Spatie Laravel Permission.
* **Multi-tenant:** `stancl/tenancy` soportando DB única o múltiples DB.
* **Middleware Tenant:** para aislar rutas según tenant.
* **CRUD dinámico:** Generadores de recursos (`artisan make:crud`) integrados con Vue/Inertia.
* **Logging / Auditoría:** `spatie/laravel-activitylog`, eventos guardados en BD y API para timeline Vue.
* **Internacionalización (i18n):** `lang/{locale}/messages.php` y API para sincronización con Vue-i18n.
* **AI Integration:** endpoint `/api/chat` conectado con OpenAI usando `openai-php/client`.
* **Policies:** separación de acceso admins vs usuarios.
* **Testing:** Pest para unit/feature tests.
* **Seeds y Factories:** preconfiguradas para Tenants, Users, Roles.

### 1.2 Frontend (Vue 3 + Inertia + Tailwind)

* **Layout Base:** Sidebar + Navbar + Header con toggle de tema.
* **UI Components:** Tablas, formularios, inputs validados con VeeValidate.
* **Notificaciones:** Toast y banners (mencionadas, integradas con Laravel Notifications).
* **Timeline:** para auditoría.
* **i18n:** sincronizado con Laravel, selector de idioma en perfil de usuario.
* **Multi-theme:** Dark/Light, preferencia guardada en BD.
* **AI Chat Widget:** `<ChatWidget>` tipo floating chat.
* **Testing:** Vitest para unit tests, Cypress/Playwright para flujos críticos.

### 1.3 Flujo Admin Panel + SaaS Starter

* Admin Panel: Foundation (Roles, CRUD, Auditoría, i18n, multi-theme)
* SaaS Starter: Extiende Admin Panel, agrega multi-tenant + billing, AI Chat integrado.

---

## 2. Módulos del Proyecto

### Backend

* **Auth:** Registro, Login, recuperación de contraseña.
* **Roles y Permisos:** Admin vs Usuario.
* **Tenants:** Gestión de tenants (multi-tenant).
* **CRUD Dinámico:** Generadores de recursos, integración con Vue.
* **Activity Log:** Auditoría de acciones.
* **AI Chat:** Endpoint `/api/chat`.

### Frontend

* **Layouts y Components:** AppLayout, formularios, tablas, modals.
* **Notificaciones:** Toast/Banners.
* **Theme y i18n:** Multi-theme y selector de idioma.
* **Chat Widget:** AI integrado.

---

## 3. Buenas Prácticas

* **Convención de nombres:**

  * PHP: PSR-12
  * Vue: PascalCase para componentes
  * Archivos: snake\_case para migraciones, camelCase para JS
* **Git Workflow:**

  * Ramas: `feature/*`, `develop`, `main`
  * Pull Requests revisados antes de merge.
* **Testing:**

  * Pest para Laravel, Vitest para Vue.
  * Siempre correr tests antes de merge.
* **Factories y Seeders:** Usar Faker para datos de prueba.
* **Linters / Formatters:** PHP-CS-Fixer, ESLint, Prettier.

---

## 4. Ejemplos de Migraciones, Seeders y Controladores

### 4.1 Migración de Users

```php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');
    $table->rememberToken();
    $table->timestamps();
});
```

### 4.2 Seeder de Users (con Faker)

```php
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

$faker = Faker::create();
DB::table('users')->insert([
    'name' => $faker->name,
    'email' => $faker->unique()->safeEmail,
    'password' => Hash::make('password123'),
    'created_at' => now(),
    'updated_at' => now(),
]);
```

### 4.3 Controlador Ejemplo

```php
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        return User::all();
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6'
        ]);

        $data['password'] = Hash::make($data['password']);
        return User::create($data);
    }
}
```

---

## 5. Tests

### 5.1 Pest (Laravel)

```php
it('creates a user', function () {
    $user = User::factory()->create();
    $this->assertDatabaseHas('users', ['email' => $user->email]);
});
```

Correr tests:

```bash
php artisan test
```

### 5.2 Vitest (Vue)

```js
import { mount } from '@vue/test-utils';
import Button from '@/Components/Button.vue';

test('renders button text', () => {
  const wrapper = mount(Button, { props: { label: 'Click me' } });
  expect(wrapper.text()).toContain('Click me');
});
```

Correr tests:

```bash
npm run test
```

---

## 6. Configuración Recomendada VSCode

* Extensiones:

  * PHP Intelephense
  * Laravel Extra Intellisense
  * ESLint
  * Prettier - Code formatter
* Configuración de linters/formatters:

  * `editor.formatOnSave: true`
  * PSR-12 para PHP
  * Prettier para JS/Vue

---

## 7. Notas Adicionales

* Proyecto ya soporta **notificaciones in-app** (Toast/Banner) integradas con Laravel Notifications.
* Multi-tenant listo con middleware y aislamiento de rutas.
* Factories y seeders listos para poblar datos de prueba.
* Makefile incluido para comandos comunes sin Docker.
* Siempre limpiar caché de configuración al cambiar `.env`:

```bash
php artisan config:clear
```

---
---

# Proyecto 1: **E-Commerce Suite Pro** 🛒📅👥
*Plataforma E-commerce + Sistema de Reservas + CRM*

## 📦 Módulos de la Aplicación

La plataforma combina **E-commerce + Sistema de Reservas + CRM** en una arquitectura modular y escalable.  
A continuación, se detallan los módulos principales y su alcance.

---

### 1. Dashboard Unificado
- Vista centralizada con métricas clave:
  - Ventas del e-commerce
  - Reservas confirmadas
  - Actividad del CRM (leads, oportunidades)
- Gráficos y KPIs en tiempo real

---

### 2. Gestión de Catálogo
- Administración de productos y servicios
- Categorías y subcategorías
- Variantes y atributos (ej: color, talle, duración de servicio)
- Gestión de imágenes y archivos (media manager)

---

### 3. Carrito de Compras & Checkout
- Carrito persistente (sesión y usuario logueado)
- Checkout con facturación y métodos de envío
- Integración de servicios reservables dentro del flujo de compra
- Métodos de pago (ej: Stripe, MercadoPago)

---

### 4. Calendario de Reservas
- Vista semanal/mensual con disponibilidad
- Creación y gestión de reservas online
- Cancelaciones y reprogramaciones
- Integración con productos/servicios del catálogo

---

### 5. Gestión de Clientes (CRM básico)
- Perfiles completos de clientes
- Historial de compras y reservas
- Notas y seguimientos manuales
- Segmentación de clientes para marketing

---

### 6. Pipeline de Ventas (CRM avanzado)
- Registro y seguimiento de leads
- Oportunidades organizadas por etapas
- Conversión de leads en clientes
- Visualización estilo Kanban

---

### 7. Reportes Integrados
- Reportes de ventas, reservas y clientes
- Analytics cruzados entre e-commerce y CRM
- Exportación a CSV/Excel
- Dashboards personalizables

---

### 8. Inventario Inteligente
- Gestión de stock en tiempo real
- Control de insumos y recursos para servicios reservables
- Alertas automáticas de bajo stock
- Sincronización con órdenes y reservas

---

### 9. Notificaciones y Comunicación
- Notificaciones in-app (Vue + Laravel Notifications)
- Confirmaciones y recordatorios por email
- Alertas de actividad (ej: nueva reserva, pago recibido)
- Integraciones futuras (WhatsApp, SMS)

---

## 🛠️ Orden sugerido de implementación

1. **Infraestructura base**: auth, roles, configuración inicial  
2. **Gestión de Catálogo**  
3. **Carrito + Checkout (E-commerce funcional)**  
4. **Calendario de Reservas**  
5. **Gestión de Clientes (CRM básico)**  
6. **Pipeline de Ventas (CRM avanzado)**  
7. **Dashboard + Reportes Integrados**  
8. **Inventario Inteligente**  
9. **Notificaciones y Comunicación**  

---
---

## Proyecto 2: **WorkFlow Manager** 🎫📊✅
*Sistema de Ticketing + Gestión de Proyectos*

### **Módulos Principales**

#### **1. Módulo de Ticketing**
```php
// Modelos de ticketing
php artisan make:model Ticket -m
php artisan make:model TicketPriority -m
php artisan make:model TicketCategory -m
php artisan make:model TicketReply -m
php artisan make:model KnowledgeBase -m
```

#### **2. Módulo de Gestión de Proyectos**
```php
// Modelos de proyectos
php artisan make:model Project -m
php artisan make:model Task -m
php artisan make:model Team -m
php artisan make:model TimeLog -m
php artisan make:model Milestone -m
```

### **Estructura de Base de Datos Detallada**

```php
// Migraciones clave
Schema::create('tickets', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('description');
    $table->foreignId('client_id'); // Puede ser interno o externo
    $table->foreignId('assigned_to')->nullable();
    $table->foreignId('priority_id');
    $table->foreignId('category_id');
    $table->enum('status', ['open', 'in_progress', 'resolved', 'closed']);
    $table->integer('sla_hours')->default(48);
    $table->timestamp('due_date')->nullable();
    $table->timestamps();
});

Schema::create('projects', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->text('description');
    $table->foreignId('manager_id');
    $table->foreignId('client_id')->nullable();
    $table->decimal('budget', 12, 2)->nullable();
    $table->date('start_date');
    $table->date('end_date');
    $table->enum('status', ['planning', 'active', 'on_hold', 'completed', 'cancelled']);
    $table->integer('progress')->default(0);
    $table->timestamps();
});

Schema::create('tasks', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('description');
    $table->foreignId('project_id');
    $table->foreignId('assigned_to');
    $table->foreignId('ticket_id')->nullable(); // Relación con tickets
    $table->enum('priority', ['low', 'medium', 'high', 'critical']);
    $table->enum('status', ['todo', 'in_progress', 'review', 'completed']);
    $table->integer('estimated_hours')->nullable();
    $table->date('due_date');
    $table->timestamps();
});
```

### **API Endpoints Principales**

```php
// routes/api.php
Route::prefix('v1')->group(function () {
    // Ticketing
    Route::apiResource('tickets', TicketController::class);
    Route::post('tickets/{ticket}/reply', [TicketController::class, 'addReply']);
    Route::patch('tickets/{ticket}/status', [TicketController::class, 'updateStatus']);
    Route::get('tickets/stats/overview', [TicketController::class, 'overviewStats']);
    
    // Proyectos
    Route::apiResource('projects', ProjectController::class);
    Route::apiResource('projects.tasks', TaskController::class)->shallow();
    Route::post('tasks/{task}/log-time', [TaskController::class, 'logTime']);
    Route::get('projects/{project}/progress', [ProjectController::class, 'progress']);
    
    // Dashboard integrado
    Route::get('workflow-dashboard', [WorkflowController::class, 'dashboard']);
});
```

### **Módulos de la Aplicación**

1. **Dashboard Unificado** - Tickets, proyectos y métricas
2. **Sistema de Ticketing** - Con SLA y categorías
3. **Gestión de Proyectos** - Con diagrama de Gantt integrado
4. **Tablero Kanban** - Para tickets y tareas
5. **Gestión de Tiempos** - Tracking de horas
6. **Base de Conocimiento** - Soluciones recurrentes
7. **Reportes de Productividad** - Métricas de equipo
8. **Integración Ticket-Tarea** - Conversión automática
9. **Alertas y Notificaciones** - Recordatorios y SLA
10. **Portal de Clientes** - Para seguimiento de tickets

