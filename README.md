# 🍦 Heladería Web - Sistema de Pedidos Personalizados 

## 📝 Descripción del Proyecto

Este proyecto consiste en una *aplicación web para una heladería*, diseñada para brindar una experiencia personalizada a los clientes. A través de esta plataforma, los usuarios pueden:

- Explorar el menú de helados por categorías.
- Realizar pedidos en línea desde la comodidad de su hogar.
- Personalizar sus productos eligiendo o quitando ingredientes.
- Aplicar promociones activas al momento de la compra.
- Acumular puntos mediante un sistema de fidelización.
- Recibir notificaciones sobre nuevos sabores, descuentos y ofertas especiales.

El sistema está desarrollado en Laravel 11 y usa MySQL como base de datos relacional, manteniendo una arquitectura clara y escalable para facilitar el proyecto.

---
🛠 Requisitos Técnicos
PHP 8.2+

Composer 2.5+

MySQL 8.0+

Laravel 10+

## ⚙️ Cómo ejecutar el proyecto

Sigue estos pasos para ejecutar el proyecto en tu entorno local:

### 1. Clonar el repositorio

git clone https://github.com/Ferchissss/heladeria.git

cd heladeria

### 2. Instalar dependencias
composer install

### 3. Configurar entorno
cp .env.example .env

php artisan key:generate

Editar .env con tus credenciales:

env

DB_DATABASE=laravel

DB_USERNAME=root

DB_PASSWORD=

### 4. Ejecutar migraciones y seeders
php artisan migrate --seed

### 5. Iniciar servidor
npm run dev
php artisan serve

Abrir en navegador: http://localhost:8000

### Evidencias de la Tarea
Migraciones y seeders ejecutadas correctamente

Base de datos generada con datos personalizados 



![1](img/Captura.PNG)  
![2](img/2.png)  


📜 Licencia  
MIT License - Copyright (c) 2025 Fernanda Estrada - Maria Celeste Ortiz

