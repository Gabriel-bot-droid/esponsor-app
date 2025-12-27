# ☕ eSponsor

**eSponsor** es una plataforma de crowdfunding (financiamiento colectivo) diseñada para conectar a creadores de contenido con sus seguidores. Permite a los usuarios crear un perfil personalizado y recibir donaciones económicas bajo la metáfora de "invitar un café", ofreciendo una alternativa simplificada a plataformas como Patreon o Ko-fi.

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Vue.js](https://img.shields.io/badge/Vue.js-35495E?style=for-the-badge&logo=vuedotjs&logoColor=4FC08D)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)

## 🚀 Características Principales

* **Landing Page de Conversión:** Página de inicio atractiva y responsiva.
* **Autenticación Robusta:** Sistema de Login y Registro seguro utilizando **Laravel Breeze**.
* **Creator Studio (Dashboard):** Panel de administración privado donde el creador puede:
    * Ver estadísticas de ganancias y seguidores.
    * Gestionar su foto de perfil y biografía.
    * Administrar enlaces a redes sociales (CRUD).
* **Perfil Público Reactivo:** Página pública accesible para cualquier usuario con un muro de donaciones en tiempo real.
* **Flujo de Donación:** Sistema de pagos simulado que permite elegir montos personalizados y dejar mensajes de apoyo.

## 🛠️ Stack Tecnológico

El proyecto fue desarrollado utilizando una arquitectura moderna basada en **Inertia.js** para construir una *Single Page Application* (SPA) monolítica.

* **Backend:** Laravel 10 (PHP 8.1+)
* **Frontend:** Vue 3 (Composition API)
* **Enrutamiento:** Inertia.js (Puente entre Laravel y Vue)
* **Estilos:** Tailwind CSS
* **Base de Datos:** MySQL
* **Componentes UI:** SweetAlert2, Qrcode.vue

---

## ⚙️ Guía de Instalación y Despliegue

Sigue estos pasos para ejecutar el proyecto en tu entorno local.

### 1. Prerrequisitos
Asegúrate de tener instalado en tu equipo:
* [PHP](https://www.php.net/) >= 8.1
* [Composer](https://getcomposer.org/)
* [Node.js](https://nodejs.org/) & NPM
* Servidor MySQL (XAMPP, Laragon, Docker, etc.)

### 2. Clonar el Repositorio
Abre tu terminal y ejecuta:

```bash
git clone https://github.com/Gabriel-bot-droid/esponsor-app.git
cd esponsor-app
```

### 3. Instalar Dependencias
Instala las librerías de PHP y los paquetes de Node.js:

```bash
composer install
npm install
```

### 4. Crear Base de Datos
Crea una base de datos vacía en MySQL. Puedes usar **phpMyAdmin**, **MySQL Workbench** o desde la terminal:

```sql
CREATE DATABASE esponsor_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 5. Configuración del Entorno (.env)
Duplica el archivo de configuración de ejemplo:

```bash
cp .env.example .env
```

Abre el archivo `.env` en tu editor de código y configura la conexión a la base de datos:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=esponsor_db
DB_USERNAME=root
DB_PASSWORD=
```

> **Nota:** Ajusta `DB_USERNAME` y `DB_PASSWORD` según tu configuración local de MySQL.

### 6. Generar Clave de Aplicación
Esto genera la `APP_KEY` necesaria para la seguridad de Laravel:

```bash
php artisan key:generate
```

### 7. Migraciones y Storage
Ejecuta las migraciones para crear las tablas en la base de datos y crea el enlace simbólico para que las imágenes de perfil sean visibles:

```bash
php artisan migrate
php artisan storage:link
```

### 8. Ejecutar el Proyecto
Para que la aplicación funcione correctamente, necesitas correr dos terminales simultáneamente:

**Terminal 1** (Vite - Compilación de Frontend):

```bash
npm run dev
```

**Terminal 2** (Servidor Laravel):

```bash
php artisan serve
```

Abre tu navegador en [http://127.0.0.1:8000](http://127.0.0.1:8000).

---

## 📖 Uso

1. **Registro:** Crea una cuenta desde `/register`
2. **Dashboard:** Accede a `/dashboard` para gestionar tu perfil y enlaces
3. **Perfil Público:** Tu página pública estará disponible en `/{username}`

---

## 🐛 Solución de Problemas

### Error de conexión a la base de datos
- Verifica que MySQL esté corriendo
- Confirma que el nombre de la base de datos, usuario y contraseña sean correctos en el `.env`

### Error "Mix manifest not found"
- Asegúrate de que `npm run dev` esté corriendo en una terminal separada

### Imágenes de perfil no se muestran
- Ejecuta `php artisan storage:link` para crear el enlace simbólico

---

## 📝 Licencia

Este proyecto es de código abierto y está disponible para fines educativos.

---

## 👤 Autor

**Gabriel**  
GitHub: [@Gabriel-bot-droid](https://github.com/Gabriel-bot-droid)