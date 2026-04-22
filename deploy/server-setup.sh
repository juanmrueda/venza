#!/bin/bash
# =============================================================
# Venza — Setup inicial del servidor (Digital Ocean Ubuntu 22.04)
# Ejecutar UNA SOLA VEZ como root en el droplet nuevo
# =============================================================
set -e

DOMAIN="venza.ipalmera.com"
WP_ROOT="/var/www/html"
DB_NAME="venza_wp"
DB_USER="venza_user"
DB_PASS="$(openssl rand -base64 16)"  # cambia esto si quieres una contraseña fija
DEPLOY_USER="deploy"

echo "============================================"
echo "  Venza — Setup del servidor"
echo "  Dominio: $DOMAIN"
echo "============================================"

# --- 1. Actualizar sistema ---
apt update && apt upgrade -y

# --- 2. Instalar Nginx, PHP 8.2, MySQL ---
apt install -y nginx mysql-server php8.2 php8.2-fpm php8.2-mysql php8.2-curl \
    php8.2-gd php8.2-mbstring php8.2-xml php8.2-zip php8.2-intl \
    unzip curl git certbot python3-certbot-nginx

# --- 3. Configurar MySQL ---
mysql -e "CREATE DATABASE IF NOT EXISTS $DB_NAME CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -e "CREATE USER IF NOT EXISTS '$DB_USER'@'localhost' IDENTIFIED BY '$DB_PASS';"
mysql -e "GRANT ALL PRIVILEGES ON $DB_NAME.* TO '$DB_USER'@'localhost';"
mysql -e "FLUSH PRIVILEGES;"

echo ""
echo "✓ Base de datos creada:"
echo "  Nombre:   $DB_NAME"
echo "  Usuario:  $DB_USER"
echo "  Password: $DB_PASS   ← GUARDA ESTO"
echo ""

# --- 4. Descargar WordPress ---
cd /tmp
curl -O https://wordpress.org/latest.tar.gz
tar xzf latest.tar.gz
cp -r wordpress/. $WP_ROOT/
chown -R www-data:www-data $WP_ROOT
chmod -R 755 $WP_ROOT
rm -rf /tmp/wordpress /tmp/latest.tar.gz

# --- 5. Configurar wp-config.php ---
cp $WP_ROOT/wp-config-sample.php $WP_ROOT/wp-config.php
sed -i "s/database_name_here/$DB_NAME/" $WP_ROOT/wp-config.php
sed -i "s/username_here/$DB_USER/"      $WP_ROOT/wp-config.php
sed -i "s/password_here/$DB_PASS/"      $WP_ROOT/wp-config.php

# Salts de seguridad
SALTS=$(curl -s https://api.wordpress.org/secret-key/1.1/salt/)
sed -i "/put your unique phrase here/d" $WP_ROOT/wp-config.php
# Insertar salts (manual — ver nota abajo)
echo "NOTA: Agrega las salts de https://api.wordpress.org/secret-key/1.1/salt/ en wp-config.php"

# --- 6. Crear usuario de deploy ---
id -u $DEPLOY_USER &>/dev/null || useradd -m -s /bin/bash $DEPLOY_USER
usermod -aG www-data $DEPLOY_USER
mkdir -p /home/$DEPLOY_USER/.ssh
chmod 700 /home/$DEPLOY_USER/.ssh

echo ""
echo "========================================================"
echo "  PASO SIGUIENTE:"
echo "  Agrega la clave pública del deploy en:"
echo "  /home/$DEPLOY_USER/.ssh/authorized_keys"
echo ""
echo "  Comando desde tu máquina local:"
echo "  cat ~/.ssh/venza_deploy.pub | ssh root@IP_SERVIDOR"
echo '  "mkdir -p /home/deploy/.ssh && cat >> /home/deploy/.ssh/authorized_keys"'
echo "========================================================"

# --- 7. Configurar Nginx ---
cat > /etc/nginx/sites-available/venza <<NGINX
server {
    listen 80;
    server_name $DOMAIN;
    root $WP_ROOT;
    index index.php index.html;

    client_max_body_size 64M;

    location / {
        try_files \$uri \$uri/ /index.php?\$args;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~* \.(css|js|jpg|jpeg|png|gif|svg|ico|woff|woff2|ttf)$ {
        expires 30d;
        add_header Cache-Control "public, no-transform";
    }

    location ~ /\.ht { deny all; }
}
NGINX

ln -sf /etc/nginx/sites-available/venza /etc/nginx/sites-enabled/
rm -f /etc/nginx/sites-enabled/default
nginx -t && systemctl reload nginx

# --- 8. SSL con Let's Encrypt ---
echo ""
echo "Para SSL ejecuta:"
echo "  certbot --nginx -d $DOMAIN --non-interactive --agree-tos -m admin@ipalmera.com"
echo ""

# --- 9. Git en el directorio del tema ---
THEME_DIR="$WP_ROOT/wp-content/themes/venza"
mkdir -p $THEME_DIR
chown $DEPLOY_USER:www-data $THEME_DIR
chmod 775 $THEME_DIR

echo ""
echo "============================================"
echo "  Setup completado."
echo "  Siguiente paso: correr deploy/deploy.sh"
echo "============================================"
