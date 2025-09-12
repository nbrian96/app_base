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

## 🛠️ Plan de Trabajo Detallado - E-Commerce Suite Pro

### **FASE 1: Infraestructura Base (Semanas 1-2)**

#### **Semana 1: Configuración Inicial**
- [x] **1.1** Configurar roles y permisos (Admin, Manager, Vendedor, Cliente)
- [ ] **1.2** Implementar autenticación con Laravel Breeze + Inertia
- [ ] **1.3** Configurar middleware de roles y políticas de acceso
- [ ] **1.4** Crear layout base con sidebar, navbar y header
- [ ] **1.5** Implementar sistema de temas (Dark/Light)
- [ ] **1.6** Configurar internacionalización (i18n) básica

#### **Semana 2: Base de Datos y Modelos**
- [ ] **2.1** Crear migraciones para entidades principales:
  - `categories`, `products`, `product_variants`
  - `customers`, `orders`, `order_items`
  - `reservations`, `services`, `availability`
  - `leads`, `opportunities`, `contacts`
- [ ] **2.2** Crear modelos con relaciones Eloquent
- [ ] **2.3** Implementar factories y seeders para datos de prueba
- [ ] **2.4** Configurar soft deletes y timestamps
- [ ] **2.5** Crear policies para control de acceso

---

### **FASE 2: Gestión de Catálogo (Semanas 3-4)**

#### **Semana 3: Productos y Categorías**
- [ ] **3.1** CRUD de categorías con árbol jerárquico
- [ ] **3.2** CRUD de productos con variantes (color, talle, etc.)
- [ ] **3.3** Gestión de imágenes y media manager
- [ ] **3.4** Sistema de atributos y especificaciones
- [ ] **3.5** Búsqueda y filtros de productos

#### **Semana 4: Servicios Reservables**
- [ ] **4.1** CRUD de servicios (diferente a productos)
- [ ] **4.2** Configuración de duración y precios
- [ ] **4.3** Gestión de recursos necesarios
- [ ] **4.4** Integración servicios con catálogo general
- [ ] **4.5** Validaciones de disponibilidad básica

---

### **FASE 3: E-commerce Funcional (Semanas 5-7)**

#### **Semana 5: Carrito de Compras**
- [ ] **5.1** Carrito persistente (sesión + usuario)
- [ ] **5.2** Agregar/remover productos del carrito
- [ ] **5.3** Cálculo de precios y descuentos
- [ ] **5.4** Validación de stock en tiempo real
- [ ] **5.5** Carrito para servicios reservables

#### **Semana 6: Checkout y Pagos**
- [ ] **6.1** Formulario de checkout multi-paso
- [ ] **6.2** Gestión de direcciones de envío
- [ ] **6.3** Cálculo de costos de envío
- [ ] **6.4** Integración con Stripe/MercadoPago
- [ ] **6.5** Confirmación de órdenes por email

#### **Semana 7: Gestión de Órdenes**
- [ ] **7.1** Panel de administración de órdenes
- [ ] **7.2** Estados de órdenes (pendiente, procesando, enviado, etc.)
- [ ] **7.3** Tracking de envíos
- [ ] **7.4** Historial de órdenes para clientes
- [ ] **7.5** Notificaciones de cambio de estado

---

### **FASE 4: Sistema de Reservas (Semanas 8-10)**

#### **Semana 8: Calendario Base**
- [ ] **8.1** Vista de calendario semanal/mensual
- [ ] **8.2** Gestión de disponibilidad por servicio
- [ ] **8.3** Configuración de horarios de trabajo
- [ ] **8.4** Días festivos y excepciones
- [ ] **8.5** Bloqueo de horarios no disponibles

#### **Semana 9: Reservas Online**
- [ ] **9.1** Formulario de reserva desde frontend
- [ ] **9.2** Validación de disponibilidad en tiempo real
- [ ] **9.3** Confirmación automática de reservas
- [ ] **9.4** Integración con carrito de compras
- [ ] **9.5** Recordatorios por email/SMS

#### **Semana 10: Gestión de Reservas**
- [ ] **10.1** Panel de administración de reservas
- [ ] **10.2** Cancelaciones y reprogramaciones
- [ ] **10.3** Lista de espera para horarios ocupados
- [ ] **10.4** Reportes de ocupación
- [ ] **10.5** Sincronización con inventario

---

### **FASE 5: CRM Básico (Semanas 11-12)**

#### **Semana 11: Gestión de Clientes**
- [ ] **11.1** Perfiles completos de clientes
- [ ] **11.2** Historial de compras y reservas
- [ ] **11.3** Notas y seguimientos manuales
- [ ] **11.4** Segmentación básica de clientes
- [ ] **11.5** Importación de contactos

#### **Semana 12: Comunicación con Clientes**
- [ ] **12.1** Sistema de notificaciones in-app
- [ ] **12.2** Templates de email personalizables
- [ ] **12.3** Campañas de marketing básicas
- [ ] **12.4** Historial de comunicaciones
- [ ] **12.5** Integración con WhatsApp (futuro)

---

### **FASE 6: CRM Avanzado (Semanas 13-15)**

#### **Semana 13: Pipeline de Ventas**
- [ ] **13.1** Registro y gestión de leads
- [ ] **13.2** Oportunidades por etapas
- [ ] **13.3** Conversión de leads a clientes
- [ ] **13.4** Visualización estilo Kanban
- [ ] **13.5** Seguimiento de actividades

#### **Semana 14: Gestión de Oportunidades**
- [ ] **14.1** Etapas personalizables del pipeline
- [ ] **14.2** Probabilidades y valores estimados
- [ ] **14.3** Tareas y recordatorios
- [ ] **14.4** Reportes de conversión
- [ ] **14.5** Integración con calendario

#### **Semana 15: Analytics CRM**
- [ ] **15.1** Métricas de ventas y conversión
- [ ] **15.2** Tiempo promedio por etapa
- [ ] **15.3** Performance por vendedor
- [ ] **15.4** Predicciones de cierre
- [ ] **15.5** Dashboards personalizables

---

### **FASE 7: Dashboard y Reportes (Semanas 16-17)**

#### **Semana 16: Dashboard Unificado**
- [ ] **16.1** Métricas clave en tiempo real
- [ ] **16.2** Gráficos de ventas y reservas
- [ ] **16.3** KPIs de CRM integrados
- [ ] **16.4** Widgets personalizables
- [ ] **16.5** Filtros por período y usuario

#### **Semana 17: Reportes Integrados**
- [ ] **17.1** Reportes de ventas detallados
- [ ] **17.2** Analytics de reservas
- [ ] **17.3** Reportes de clientes y CRM
- [ ] **17.4** Exportación a CSV/Excel
- [ ] **17.5** Reportes programados por email

---

### **FASE 8: Inventario Inteligente (Semanas 18-19)**

#### **Semana 18: Gestión de Stock**
- [ ] **18.1** Control de inventario en tiempo real
- [ ] **18.2** Alertas de bajo stock
- [ ] **18.3** Gestión de insumos para servicios
- [ ] **18.4** Sincronización con órdenes
- [ ] **18.5** Códigos de barras y SKUs

#### **Semana 19: Optimización de Inventario**
- [ ] **19.1** Predicción de demanda
- [ ] **19.2** Puntos de reorden automáticos
- [ ] **19.3** Gestión de proveedores
- [ ] **19.4** Reportes de rotación
- [ ] **19.5** Integración con reservas

---

### **FASE 9: Notificaciones y Comunicación (Semana 20)**

#### **Semana 20: Sistema de Notificaciones**
- [ ] **20.1** Notificaciones in-app (Vue + Laravel)
- [ ] **20.2** Confirmaciones automáticas por email
- [ ] **20.3** Recordatorios de reservas
- [ ] **20.4** Alertas de actividad crítica
- [ ] **20.5** Configuración de preferencias

---

### **FASE 10: Testing y Optimización (Semanas 21-22)**

#### **Semana 21: Testing Integral**
- [ ] **21.1** Tests unitarios con Pest (Laravel)
- [ ] **21.2** Tests de integración para flujos críticos
- [ ] **21.3** Tests de frontend con Vitest
- [ ] **21.4** Tests E2E con Cypress/Playwright
- [ ] **21.5** Testing de performance

#### **Semana 22: Optimización y Deploy**
- [ ] **22.1** Optimización de consultas de BD
- [ ] **22.2** Caché de datos frecuentes
- [ ] **22.3** Optimización de assets frontend
- [ ] **22.4** Configuración de producción
- [ ] **22.5** Documentación final y manual de usuario

---

## 📊 **Cronograma Resumido**

| Fase | Duración | Módulos Principales |
|------|----------|-------------------|
| **Fase 1** | 2 semanas | Infraestructura base, Auth, Roles |
| **Fase 2** | 2 semanas | Catálogo, Productos, Servicios |
| **Fase 3** | 3 semanas | E-commerce funcional |
| **Fase 4** | 3 semanas | Sistema de Reservas |
| **Fase 5** | 2 semanas | CRM Básico |
| **Fase 6** | 3 semanas | CRM Avanzado |
| **Fase 7** | 2 semanas | Dashboard y Reportes |
| **Fase 8** | 2 semanas | Inventario Inteligente |
| **Fase 9** | 1 semana | Notificaciones |
| **Fase 10** | 2 semanas | Testing y Deploy |
| **TOTAL** | **22 semanas** | **Proyecto Completo** |

---

## 🎯 **Entregables por Fase**

- **Fase 1-2**: Sistema base funcional con catálogo
- **Fase 3**: E-commerce completamente operativo
- **Fase 4**: Sistema de reservas integrado
- **Fase 5-6**: CRM completo con pipeline
- **Fase 7**: Dashboard unificado con reportes
- **Fase 8**: Inventario inteligente
- **Fase 9**: Sistema de notificaciones
- **Fase 10**: Producto final optimizado y documentado  

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

---

## Proyecto 3: **Planificador de Materias** 🎓📚📊
*Sistema de Gestión Académica y Planificación de Carreras*

### **Módulos Principales**

#### **1. Gestión de Carreras y Planes de Estudio**
```php
// Modelos principales
php artisan make:model Career -m
php artisan make:model Subject -m
php artisan make:model SubjectCorrelative -m
php artisan make:model GradeScale -m
php artisan make:model Enrollment -m
php artisan make:model SubjectEnrollment -m
php artisan make:model Grade -m
```

#### **2. Gestión de Estudiantes y Calificaciones**
```php
// Modelos adicionales
php artisan make:model Student -m
php artisan make:model AcademicPeriod -m
php artisan make:model GradeType -m
php artisan make:model AcademicHistory -m
```

### **Estructura de Base de Datos Detallada**

```php
// Migraciones clave
Schema::create('careers', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('code')->unique();
    $table->text('description');
    $table->integer('total_credits');
    $table->integer('duration_years');
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});

Schema::create('subjects', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('code')->unique();
    $table->text('description');
    $table->foreignId('career_id');
    $table->integer('credits');
    $table->integer('semester'); // Cuatrimestre
    $table->boolean('is_elective')->default(false);
    $table->boolean('is_final_subject')->default(false); // Materia final
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});

Schema::create('subject_correlatives', function (Blueprint $table) {
    $table->id();
    $table->foreignId('subject_id'); // Materia que requiere correlativa
    $table->foreignId('correlative_subject_id'); // Materia correlativa
    $table->enum('type', ['required', 'recommended'])->default('required');
    $table->timestamps();
    
    $table->unique(['subject_id', 'correlative_subject_id']);
});

Schema::create('grade_scales', function (Blueprint $table) {
    $table->id();
    $table->string('name'); // Ej: "Escala 0-10", "Escala A-F"
    $table->json('scale'); // Configuración de la escala
    $table->decimal('passing_grade', 3, 2); // Nota mínima para aprobar
    $table->boolean('is_default')->default(false);
    $table->timestamps();
});

Schema::create('students', function (Blueprint $table) {
    $table->id();
    $table->string('student_id')->unique(); // Número de legajo
    $table->string('first_name');
    $table->string('last_name');
    $table->string('email')->unique();
    $table->string('phone')->nullable();
    $table->date('birth_date');
    $table->enum('status', ['active', 'inactive', 'graduated', 'dropped'])->default('active');
    $table->timestamps();
});

Schema::create('enrollments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('student_id');
    $table->foreignId('career_id');
    $table->date('enrollment_date');
    $table->enum('status', ['active', 'paused', 'completed', 'dropped'])->default('active');
    $table->decimal('gpa', 3, 2)->nullable(); // Promedio general
    $table->integer('total_credits_earned')->default(0);
    $table->timestamps();
});

Schema::create('subject_enrollments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('enrollment_id');
    $table->foreignId('subject_id');
    $table->foreignId('academic_period_id');
    $table->enum('status', ['enrolled', 'in_progress', 'completed', 'failed', 'dropped'])->default('enrolled');
    $table->date('enrollment_date');
    $table->date('completion_date')->nullable();
    $table->timestamps();
    
    $table->unique(['enrollment_id', 'subject_id', 'academic_period_id']);
});

Schema::create('grades', function (Blueprint $table) {
    $table->id();
    $table->foreignId('subject_enrollment_id');
    $table->foreignId('grade_type_id'); // Cursada, Final, Recuperatorio, etc.
    $table->decimal('grade', 4, 2); // Nota numérica
    $table->string('grade_letter')->nullable(); // A, B, C, etc.
    $table->enum('status', ['approved', 'failed', 'equivalence'])->default('approved');
    $table->date('grade_date');
    $table->text('comments')->nullable();
    $table->timestamps();
});

Schema::create('grade_types', function (Blueprint $table) {
    $table->id();
    $table->string('name'); // Cursada, Final, Recuperatorio, Equivalencia
    $table->string('code')->unique();
    $table->boolean('is_final')->default(false);
    $table->decimal('weight', 3, 2)->default(1.00); // Peso en el promedio
    $table->timestamps();
});

Schema::create('academic_periods', function (Blueprint $table) {
    $table->id();
    $table->string('name'); // 2024-1, 2024-2, etc.
    $table->date('start_date');
    $table->date('end_date');
    $table->boolean('is_active')->default(false);
    $table->timestamps();
});

Schema::create('academic_histories', function (Blueprint $table) {
    $table->id();
    $table->foreignId('student_id');
    $table->foreignId('subject_id');
    $table->foreignId('academic_period_id');
    $table->decimal('final_grade', 4, 2);
    $table->enum('status', ['approved', 'failed', 'equivalence']);
    $table->integer('credits_earned');
    $table->date('completion_date');
    $table->timestamps();
});
```

### **API Endpoints Principales**

```php
// routes/api.php
Route::prefix('v1')->group(function () {
    // Carreras y Materias
    Route::apiResource('careers', CareerController::class);
    Route::apiResource('careers.subjects', SubjectController::class)->shallow();
    Route::post('subjects/{subject}/correlatives', [SubjectController::class, 'addCorrelative']);
    Route::delete('subjects/{subject}/correlatives/{correlative}', [SubjectController::class, 'removeCorrelative']);
    
    // Estudiantes y Matriculaciones
    Route::apiResource('students', StudentController::class);
    Route::apiResource('students.enrollments', EnrollmentController::class)->shallow();
    Route::post('enrollments/{enrollment}/subjects', [EnrollmentController::class, 'enrollInSubject']);
    Route::delete('enrollments/{enrollment}/subjects/{subject}', [EnrollmentController::class, 'unenrollFromSubject']);
    
    // Calificaciones
    Route::apiResource('subject-enrollments.grades', GradeController::class)->shallow();
    Route::post('grades/{grade}/equivalence', [GradeController::class, 'markAsEquivalence']);
    Route::get('students/{student}/academic-history', [StudentController::class, 'academicHistory']);
    
    // Reportes y Analytics
    Route::get('careers/{career}/progress-report', [CareerController::class, 'progressReport']);
    Route::get('students/{student}/progress', [StudentController::class, 'progress']);
    Route::get('academic-dashboard', [AcademicController::class, 'dashboard']);
});
```

### **Módulos de la Aplicación**

1. **Dashboard Académico** - Métricas generales y progreso de estudiantes
2. **Gestión de Carreras** - Creación y administración de planes de estudio
3. **Gestión de Materias** - CRUD de materias con correlativas y configuraciones
4. **Matriculación de Estudiantes** - Inscripción a carreras y materias
5. **Sistema de Calificaciones** - Registro de notas con escalas configurables
6. **Historial Académico** - Seguimiento completo del progreso estudiantil
7. **Reportes de Progreso** - Analytics de rendimiento y estadísticas
8. **Gestión de Períodos Académicos** - Administración de cuatrimestres/semestres
9. **Validación de Correlativas** - Control automático de prerrequisitos
10. **Portal del Estudiante** - Vista personalizada del progreso académico

### **Características Especiales**

#### **Sistema de Escalas de Notas**
- Escala 0-10 (por defecto)
- Escala A-F (opcional)
- Nota "Equivalencia" para materias aprobadas en otras instituciones
- Configuración flexible de notas mínimas para aprobar

#### **Gestión de Correlativas**
- Correlativas obligatorias vs recomendadas
- Validación automática al inscribirse a materias
- Visualización de dependencias en el plan de estudio

#### **Seguimiento de Progreso**
- Cálculo automático de GPA (Grade Point Average)
- Progreso por cuatrimestre y carrera completa
- Alertas de materias próximas a vencer
- Estimación de tiempo de graduación

#### **Reportes y Analytics**
- Estadísticas de aprobación por materia
- Tiempo promedio de graduación por carrera
- Análisis de rendimiento por período académico
- Reportes de materias con mayor índice de reprobación

### **Plan de Trabajo - Planificador de Materias**

#### **FASE 1: Infraestructura Base (Semanas 1-2)**
- [ ] **1.1** Configurar roles (Admin, Coordinador, Estudiante)
- [ ] **1.2** Crear migraciones de carreras y materias
- [ ] **1.3** Implementar sistema de escalas de notas
- [ ] **1.4** Configurar períodos académicos

#### **FASE 2: Gestión Académica (Semanas 3-4)**
- [ ] **2.1** CRUD de carreras con validaciones
- [ ] **2.2** CRUD de materias con correlativas
- [ ] **2.3** Sistema de períodos académicos
- [ ] **2.4** Validación de prerrequisitos

#### **FASE 3: Matriculación (Semanas 5-6)**
- [ ] **3.1** Gestión de estudiantes
- [ ] **3.2** Sistema de matriculación a carreras
- [ ] **3.3** Inscripción a materias por período
- [ ] **3.4** Validación de correlativas en inscripciones

#### **FASE 4: Sistema de Calificaciones (Semanas 7-8)**
- [ ] **4.1** Registro de notas de cursada y final
- [ ] **4.2** Sistema de equivalencias
- [ ] **4.3** Cálculo automático de promedios
- [ ] **4.4** Historial académico completo

#### **FASE 5: Reportes y Analytics (Semanas 9-10)**
- [ ] **5.1** Dashboard académico
- [ ] **5.2** Reportes de progreso estudiantil
- [ ] **5.3** Analytics de rendimiento
- [ ] **5.4** Portal del estudiante

### **Cronograma Resumido - Planificador de Materias**

| Fase | Duración | Módulos Principales |
|------|----------|-------------------|
| **Fase 1** | 2 semanas | Infraestructura base, Roles, BD |
| **Fase 2** | 2 semanas | Gestión de carreras y materias |
| **Fase 3** | 2 semanas | Sistema de matriculación |
| **Fase 4** | 2 semanas | Calificaciones y equivalencias |
| **Fase 5** | 2 semanas | Reportes y portal estudiantil |
| **TOTAL** | **10 semanas** | **Sistema Académico Completo** |

