# Sistema de Cooperadora Escolar - EET3107 Juana Azurduy de Padilla

<p align="center">
  <img src="public/images/escudo.png" alt="Escudo EET3107" width="150">
</p>

Sistema web completo para la gestión de ingresos y comprobantes de la cooperadora escolar, desarrollado con Laravel 11, React (Inertia.js) y Tailwind CSS.

## ✨ Características Principales

### 🏫 Gestión de Alumnos
- **CRUD completo** de alumnos con validación de datos
- **Búsqueda por DNI** para asociación automática en comprobantes
- **Validación de DNI** con formato argentino
- **Gestión de emails** para envío de comprobantes

### 💰 Sistema de Ingresos
- **Creación y edición** de comprobantes de ingresos
- **Múltiples conceptos** por comprobante con cálculo automático
- **Gestión de cantidades** y totales por concepto
- **Validación completa** de formularios con feedback en tiempo real
- **Persistencia de datos** al actualizar (se mantiene en el formulario de edición)

### 📄 Generación de Comprobantes
- **Vista de impresión** optimizada con diseño profesional
- **Captura HTML a imagen** para impresión de alta calidad
- **Comprobantes numerados** automáticamente
- **Conversión de números a texto** en español para montos
- **Diseño responsive** con marca de agua del escudo institucional

### 📧 Sistema de Email
- **Envío automático** de comprobantes por email
- **Integración con Mailtrap** para desarrollo/testing
- **Templates optimizados** para clientes de email
- **Imágenes embebidas** en base64 para compatibilidad
- **Gestión de sesión** para emails temporales
- **Notificaciones visuales** con popups de éxito/error

### 🖨️ Funciones de Impresión
- **Vista dedicada** para impresión `/ingresos/{id}/print`
- **Captura HTML2Canvas** para impresión precisa
- **Botones de acción** intuitivos (Imprimir, Email, Cerrar)
- **Feedback visual** con popups temporales de estado

## 🛠️ Stack Tecnológico

### Backend
- **Laravel 11** - Framework PHP moderno
- **SQLite** - Base de datos ligera
- **Eloquent ORM** - Relaciones y migraciones
- **Validation** - Validación robusta de formularios
- **Mail System** - Envío de emails con templates

### Frontend
- **React 18** - Biblioteca de UI moderna
- **Inertia.js** - SPA sin API
- **Tailwind CSS** - Framework CSS utilitario
- **HTML2Canvas** - Captura de elementos HTML

### Desarrollo
- **Vite** - Build tool y hot reload
- **Laravel Mix** - Asset compilation
- **Git** - Control de versiones

## ⚙️ Configuración del Proyecto

### Requisitos
- PHP 8.2+
- Composer
- Node.js 18+
- SQLite

### Instalación

1. **Clonar el repositorio**
```bash
git clone https://github.com/SofiRoadToDev/cooperadora.git
cd cooperadora
```

2. **Instalar dependencias PHP**
```bash
composer install
```

3. **Instalar dependencias JavaScript**
```bash
npm install
```

4. **Configurar entorno**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Configurar base de datos**
```bash
touch database/database.sqlite
php artisan migrate --seed
```

6. **Compilar assets**
```bash
npm run build
# O para desarrollo:
npm run dev
```

7. **Iniciar servidor**
```bash
php artisan serve
```

### Configuración de Email

Para habilitar el envío de emails, configura estas variables en `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=tu_username
MAIL_PASSWORD=tu_password
MAIL_ENCRYPTION=
MAIL_FROM_ADDRESS="cooperadora@eet3107.edu.ar"
MAIL_FROM_NAME="EET3107 Cooperadora"
```

## 🎯 Funcionalidades Implementadas

### ✅ Módulo de Alumnos
- [x] Listado con paginación y búsqueda
- [x] Crear/Editar/Eliminar alumnos
- [x] Validación de DNI argentino
- [x] Gestión de emails

### ✅ Módulo de Conceptos
- [x] CRUD de conceptos de pago
- [x] Precios configurables
- [x] Asociación con comprobantes

### ✅ Módulo de Ingresos
- [x] Formulario dinámico de creación
- [x] Búsqueda de alumno por DNI
- [x] Múltiples conceptos por comprobante
- [x] Cálculo automático de totales
- [x] Validación de formato de hora (H:i)
- [x] Persistencia en modo edición

### ✅ Sistema de Comprobantes
- [x] Numeración automática
- [x] Conversión de números a texto
- [x] Vista de impresión profesional
- [x] Captura HTML2Canvas
- [x] Marca de agua institucional

### ✅ Sistema de Email
- [x] Envío de comprobantes
- [x] Templates responsive
- [x] Imágenes base64 embebidas
- [x] Manejo de errores
- [x] Notificaciones visuales

### ✅ Experiencia de Usuario
- [x] Interfaz responsive
- [x] Feedback visual inmediato
- [x] Popups de notificación
- [x] Formularios intuitivos
- [x] Navegación fluida

## 📁 Estructura del Proyecto

```
cooperadora/
├── app/
│   ├── Http/Controllers/
│   │   ├── AlumnoController.php     # Gestión de alumnos
│   │   ├── ConceptoController.php   # Gestión de conceptos
│   │   └── IngresoController.php    # Gestión de ingresos
│   ├── Mail/
│   │   └── FacturaMail.php          # Email de comprobantes
│   └── Models/
│       ├── Alumno.php               # Modelo de alumnos
│       ├── Concepto.php             # Modelo de conceptos
│       └── Ingreso.php              # Modelo de ingresos
├── resources/
│   ├── js/Components/
│   │   ├── Ingreso/
│   │   │   ├── IngresoForm.jsx      # Formulario de ingresos
│   │   │   └── ConceptoBlock.jsx    # Bloque de concepto
│   │   └── Alert.jsx                # Componente de alertas
│   └── views/
│       ├── mails/
│       │   └── recibo.blade.php     # Template de email
│       └── pdf/
│           └── recibo-print.blade.php # Vista de impresión
├── database/
│   └── migrations/                  # Migraciones de BD
└── public/
    └── images/
        └── escudo.png               # Logo institucional
```

## 🔧 Comandos Útiles

```bash
# Desarrollo
npm run dev                    # Hot reload assets
php artisan serve             # Servidor desarrollo

# Base de datos
php artisan migrate:fresh --seed  # Reset BD con datos
php artisan tinker                # REPL de Laravel

# Cache
php artisan config:clear          # Limpiar cache config
php artisan route:clear           # Limpiar cache rutas

# Logs
tail -f storage/logs/laravel.log  # Ver logs en tiempo real
```

## 🎨 Capturas de Pantalla

### Dashboard de Ingresos
Interfaz principal con listado de comprobantes, búsqueda y filtros.

### Formulario de Comprobantes
Formulario dinámico con búsqueda de alumnos y gestión de múltiples conceptos.

### Vista de Impresión
Comprobante profesional listo para imprimir con todos los detalles.

### Email de Comprobante
Template optimizado para clientes de email con diseño responsive.

## 👥 Desarrollado por

- **SofiRoadToDev** - Desarrollo Full Stack
- **Claude (Anthropic)** - Asistencia en desarrollo y documentación

## 📄 Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo `LICENSE` para más detalles.

---

<p align="center">
  <strong>Sistema desarrollado para EET3107 "Juana Azurduy de Padilla"</strong><br>
  🏫 Gestión moderna de cooperadora escolar 🏫
</p>