#!/bin/bash

# Clinic System - VPS Deployment Script
# This script sets up the Laravel application on a fresh VPS

set -e

echo "🚀 Starting Clinic System Deployment..."

# Update system packages
echo "📦 Updating system packages..."
sudo apt update && sudo apt upgrade -y

# Install required packages
echo "📦 Installing required packages..."
sudo apt install -y \
    nginx \
    mysql-server \
    php8.2 \
    php8.2-fpm \
    php8.2-mysql \
    php8.2-mbstring \
    php8.2-xml \
    php8.2-bcmath \
    php8.2-curl \
    php8.2-zip \
    php8.2-gd \
    git \
    unzip \
    curl

# Install Composer
echo "📦 Installing Composer..."
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer

# Setup MySQL database
echo "🗄️  Setting up MySQL database..."
sudo mysql -e "CREATE DATABASE IF NOT EXISTS clinic_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
sudo mysql -e "CREATE USER IF NOT EXISTS 'clinic_user'@'localhost' IDENTIFIED BY 'CHANGE_THIS_PASSWORD';"
sudo mysql -e "GRANT ALL PRIVILEGES ON clinic_db.* TO 'clinic_user'@'localhost';"
sudo mysql -e "FLUSH PRIVILEGES;"

# Clone repository
echo "📥 Cloning repository..."
cd /var/www
sudo git clone https://github.com/marwan-salah5/Clinic.git clinic-system
cd clinic-system

# Set permissions
echo "🔐 Setting permissions..."
sudo chown -R www-data:www-data /var/www/clinic-system
sudo chmod -R 755 /var/www/clinic-system
sudo chmod -R 775 /var/www/clinic-system/storage
sudo chmod -R 775 /var/www/clinic-system/bootstrap/cache

# Install dependencies
echo "📦 Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader

# Setup environment
echo "⚙️  Setting up environment..."
cp .env.example .env
php artisan key:generate

# Update .env with database credentials
echo "⚙️  Configuring database..."
sed -i 's/DB_DATABASE=.*/DB_DATABASE=clinic_db/' .env
sed -i 's/DB_USERNAME=.*/DB_USERNAME=clinic_user/' .env
sed -i 's/DB_PASSWORD=.*/DB_PASSWORD=CHANGE_THIS_PASSWORD/' .env

# Run migrations
echo "🗄️  Running database migrations..."
php artisan migrate --force --seed

# Optimize Laravel
echo "⚡ Optimizing Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Configure Nginx
echo "🌐 Configuring Nginx..."
sudo tee /etc/nginx/sites-available/clinic-system > /dev/null <<EOF
server {
    listen 80;
    server_name YOUR_DOMAIN_OR_IP;
    root /var/www/clinic-system/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME \$realpath_root\$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
EOF

# Enable site
sudo ln -sf /etc/nginx/sites-available/clinic-system /etc/nginx/sites-enabled/
sudo rm -f /etc/nginx/sites-enabled/default

# Test and reload Nginx
echo "🔄 Reloading Nginx..."
sudo nginx -t
sudo systemctl reload nginx

# Setup SSH key for GitHub (for auto-deployment)
echo "🔑 Setting up SSH key for GitHub..."
echo "Please add the following public key to your GitHub repository's Deploy Keys:"
echo "Go to: https://github.com/marwan-salah5/Clinic/settings/keys"
echo ""
sudo -u www-data ssh-keygen -t ed25519 -C "vps-deployment" -f /var/www/.ssh/id_ed25519 -N ""
sudo -u www-data cat /var/www/.ssh/id_ed25519.pub

echo ""
echo "✅ Deployment completed successfully!"
echo ""
echo "📝 Next steps:"
echo "1. Update the database password in /var/www/clinic-system/.env"
echo "2. Update YOUR_DOMAIN_OR_IP in /etc/nginx/sites-available/clinic-system"
echo "3. Add the SSH public key above to GitHub Deploy Keys"
echo "4. Add the following secrets to GitHub repository settings:"
echo "   - VPS_HOST: Your VPS IP address"
echo "   - VPS_USERNAME: www-data"
echo "   - VPS_SSH_KEY: Content of /var/www/.ssh/id_ed25519 (private key)"
echo ""
echo "🌐 Your application should now be accessible at http://YOUR_DOMAIN_OR_IP"
