# 🚀 Guía de Despliegue - Google Cloud Platform (Free Tier)

Esta guía te ayudará a desplegar el Sistema de Cooperadora Escolar en una instancia gratuita de Google Cloud Platform.

## 📋 Requisitos Previos

- ✅ Cuenta de Google Cloud Platform (con $300 de crédito gratuito)
- ✅ Proyecto terminado y funcionando localmente
- ✅ Acceso a terminal/SSH
- ✅ Conocimientos básicos de Linux

## 🏗️ Arquitectura de Despliegue

```
Internet → Nginx → PHP-FPM → Laravel App → SQLite
                              ↓
                           Email (SMTP)
```

## 🎯 Paso 1: Configurar Instancia en GCP

### 1.1 Crear Proyecto en GCP

1. Ve a [Google Cloud Console](https://console.cloud.google.com/)
2. Crea un nuevo proyecto:
   - Nombre: `cooperadora-eet3107`
   - ID: `cooperadora-eet3107-[random]`
3. Habilita la API de Compute Engine

### 1.2 Crear Instancia VM

1. **Navega a Compute Engine > VM Instances**
2. **Click "Create Instance"**
3. **Configuración de la instancia:**

```yaml
Nombre: cooperadora-server
Región: us-east1 (Virginia) # Más barata
Zona: us-east1-b
Tipo de máquina:
  - Series: E2
  - Tipo: e2-micro (1 vCPU, 1 GB memoria) # FREE TIER
Boot disk:
  - OS: Ubuntu
  - Versión: Ubuntu 22.04 LTS
  - Tamaño: 30 GB (máximo gratuito)
  - Tipo: Standard persistent disk
Firewall:
  - ✅ Allow HTTP traffic
  - ✅ Allow HTTPS traffic
```

4. **Click "Create"** y espera a que la instancia se inicie

## 🔧 Paso 2: Configurar Servidor Web

### 2.1 Conectar por SSH

```bash
# Desde GCP Console, click "SSH" en tu instancia
# O usa gcloud CLI:
gcloud compute ssh --zone=us-east1-b --project=tu-proyecto cooperadora-server
```

### 2.2 Actualizar Sistema

```bash
sudo apt update && sudo apt upgrade -y
```

### 2.3 Instalar Nginx

```bash
sudo apt install nginx -y
sudo systemctl enable nginx
sudo systemctl start nginx
```

### 2.4 Instalar PHP 8.2

```bash
# Agregar repositorio de PHP
sudo apt install software-properties-common -y
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update

# Instalar PHP y extensiones necesarias
sudo apt install php8.2-fpm php8.2-cli php8.2-curl php8.2-zip \
                 php8.2-gd php8.2-mbstring php8.2-xml php8.2-sqlite3 \
                 php8.2-intl php8.2-bcmath -y

# Verificar instalación
php --version
```

### 2.5 Instalar Composer

```bash
cd ~
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
composer --version
```

### 2.6 Instalar Node.js y npm

```bash
# Instalar NodeSource repository
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt-get install -y nodejs

# Verificar instalación
node --version
npm --version
```

## 📁 Paso 3: Desplegar Aplicación

### 3.1 Clonar Repositorio

```bash
cd /var/www
sudo git clone https://github.com/SofiRoadToDev/cooperadora.git
sudo chown -R $USER:$USER cooperadora
cd cooperadora
```

### 3.2 Instalar Dependencias PHP

```bash
composer install --optimize-autoloader --no-dev
```

### 3.3 Configurar Archivo .env

```bash
cp .env.example .env
nano .env
```

**Configuración para producción:**

```env
APP_NAME="Cooperadora EET3107"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_TIMEZONE=America/Argentina/Salta
APP_URL=http://tu-ip-externa

DB_CONNECTION=sqlite
# DB_DATABASE se configura automáticamente

# Email Configuration (Usar servicio real en producción)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu-email@gmail.com
MAIL_PASSWORD=tu-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="cooperadora@eet3107.edu.ar"
MAIL_FROM_NAME="EET3107 Cooperadora"

# Logging
LOG_CHANNEL=single
LOG_LEVEL=error

# Session
SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=database
```

### 3.4 Generar Key y Configurar DB

```bash
php artisan key:generate
touch database/database.sqlite
php artisan migrate --force
php artisan db:seed --force
```

### 3.5 Instalar Dependencias Frontend

```bash
npm install
npm run build
```

### 3.6 Configurar Permisos

```bash
sudo chown -R www-data:www-data /var/www/cooperadora
sudo chmod -R 755 /var/www/cooperadora
sudo chmod -R 775 /var/www/cooperadora/storage
sudo chmod -R 775 /var/www/cooperadora/bootstrap/cache
```

## 🌐 Paso 4: Configurar Nginx

### 4.1 Crear Configuración del Sitio

```bash
sudo nano /etc/nginx/sites-available/cooperadora
```

**Contenido del archivo:**

```nginx
server {
    listen 80;
    server_name tu-ip-externa www.tu-dominio.com;
    root /var/www/cooperadora/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    # Logs
    access_log /var/log/nginx/cooperadora-access.log;
    error_log /var/log/nginx/cooperadora-error.log;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    # Static files optimization
    location ~* \.(js|css|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
        access_log off;
    }
}
```

### 4.2 Habilitar Sitio

```bash
sudo ln -s /etc/nginx/sites-available/cooperadora /etc/nginx/sites-enabled/
sudo rm /etc/nginx/sites-enabled/default
sudo nginx -t
sudo systemctl reload nginx
```

## 🔒 Paso 5: Configurar Firewall y SSL (Opcional)

### 5.1 Configurar UFW

```bash
sudo ufw enable
sudo ufw allow 22    # SSH
sudo ufw allow 80    # HTTP
sudo ufw allow 443   # HTTPS
sudo ufw status
```

### 5.2 Instalar SSL con Let's Encrypt (Opcional)

```bash
sudo apt install certbot python3-certbot-nginx -y
sudo certbot --nginx -d tu-dominio.com -d www.tu-dominio.com
```

## 📧 Paso 6: Configurar Email en Producción

### Opción 1: Gmail SMTP

1. **Habilitar 2FA** en tu cuenta de Gmail
2. **Generar App Password:**
   - Ve a Google Account Settings
   - Security → 2-Step Verification → App passwords
   - Genera password para "Mail"
3. **Usar en .env:**

```env
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu-email@gmail.com
MAIL_PASSWORD=tu-app-password-generado
MAIL_ENCRYPTION=tls
```

### Opción 2: SendGrid (Recomendado para producción)

1. Crear cuenta en [SendGrid](https://sendgrid.com/)
2. Verificar dominio
3. Generar API Key
4. Configurar en .env:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=tu-sendgrid-api-key
```

## 🔧 Paso 7: Optimizaciones y Mantenimiento

### 7.1 Configurar Cache

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 7.2 Configurar Cron Jobs

```bash
sudo crontab -e -u www-data
```

Agregar:
```bash
* * * * * cd /var/www/cooperadora && php artisan schedule:run >> /dev/null 2>&1
```

### 7.3 Configurar Logs Rotation

```bash
sudo nano /etc/logrotate.d/laravel
```

```
/var/www/cooperadora/storage/logs/*.log {
    daily
    missingok
    rotate 14
    compress
    delaycompress
    notifempty
    create 0640 www-data www-data
}
```

### 7.4 Script de Backup

```bash
nano ~/backup-cooperadora.sh
chmod +x ~/backup-cooperadora.sh
```

**Contenido del script:**

```bash
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/home/$(whoami)/backups"
APP_DIR="/var/www/cooperadora"

mkdir -p $BACKUP_DIR

# Backup database
cp $APP_DIR/database/database.sqlite $BACKUP_DIR/database_$DATE.sqlite

# Backup uploads/important files
tar -czf $BACKUP_DIR/storage_$DATE.tar.gz $APP_DIR/storage/app

# Keep only last 7 days
find $BACKUP_DIR -name "*.sqlite" -mtime +7 -delete
find $BACKUP_DIR -name "*.tar.gz" -mtime +7 -delete

echo "Backup completed: $DATE"
```

**Programar backup diario:**

```bash
crontab -e
# Agregar:
0 2 * * * /home/$(whoami)/backup-cooperadora.sh
```

## 🚀 Paso 8: Acceso Final

### 8.1 Obtener IP Externa

```bash
# En GCP Console, ve a VM Instances
# Copia la "External IP" de tu instancia
# Ejemplo: 34.123.45.67
```

### 8.2 Configurar DNS (Opcional)

Si tienes un dominio:
1. Ve a tu proveedor de DNS
2. Crea registro A: `cooperadora.tuescuela.edu.ar` → `34.123.45.67`
3. Actualiza APP_URL en .env

### 8.3 Primer Acceso

1. **Abre navegador:** `http://tu-ip-externa`
2. **Login por defecto:**
   - Email: `admin@eet3107.edu.ar`
   - Password: `password123`
3. **¡Cambia la contraseña inmediatamente!**

## 📊 Monitoreo y Logs

### Ver logs de aplicación:
```bash
tail -f /var/www/cooperadora/storage/logs/laravel.log
```

### Ver logs de Nginx:
```bash
sudo tail -f /var/log/nginx/cooperadora-error.log
sudo tail -f /var/log/nginx/cooperadora-access.log
```

### Ver status de servicios:
```bash
sudo systemctl status nginx
sudo systemctl status php8.2-fpm
```

## 🔧 Troubleshooting

### Problema: Error 500
```bash
# Verificar permisos
sudo chown -R www-data:www-data /var/www/cooperadora
sudo chmod -R 755 /var/www/cooperadora
sudo chmod -R 775 /var/www/cooperadora/storage

# Verificar logs
tail -f /var/www/cooperadora/storage/logs/laravel.log
```

### Problema: No envía emails
```bash
# Verificar configuración SMTP
php artisan tinker
Mail::raw('Test email', function($msg) { $msg->to('test@example.com'); });
```

### Problema: Nginx no inicia
```bash
sudo nginx -t  # Verificar sintaxis
sudo systemctl status nginx
sudo journalctl -u nginx
```

## 💰 Costos Estimados (Free Tier)

- **Instancia e2-micro:** $0/mes (730 horas gratuitas)
- **Disco 30GB:** $0/mes (30GB gratuitos)
- **Tráfico de red:** $0/mes (1GB salida gratis)
- **Total:** $0/mes dentro de límites gratuitos

## ⚠️ Límites del Free Tier

- 1 instancia e2-micro por región
- 730 horas/mes de compute
- 30 GB de disco HDD
- 1 GB de tráfico de salida/mes
- 5 GB de snapshots

## 🎯 Próximos Pasos

1. **Configurar dominio personalizado**
2. **Implementar SSL/HTTPS**
3. **Configurar backups automáticos**
4. **Monitoreo con Google Cloud Monitoring**
5. **Configurar alertas de recursos**

---

## 📞 Soporte

Si encuentras problemas durante el despliegue:

1. **Revisa los logs** de aplicación y servidor
2. **Verifica permisos** de archivos y directorios
3. **Confirma configuración** de .env
4. **Consulta documentación** de Laravel y GCP

**¡Tu Sistema de Cooperadora Escolar está listo para producción!** 🎉

---

<p align="center">
  <strong>Sistema desplegado en Google Cloud Platform</strong><br>
  🌐 Accesible desde cualquier lugar del mundo 🌐
</p>