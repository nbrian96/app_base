# Proyecto Base Software Factory 🚀

## Proyecto: **Planificador de Materias** 🎓📚📊
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
- Correlativas obligatorias
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

