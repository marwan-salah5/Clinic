#!/bin/bash

# Clinic System - CyberPanel Deployment Script
# This script updates the Laravel application from GitHub

set -e

echo "🚀 Starting Clinic System Update..."

# Get the website path (change this to your actual path)
SITE_PATH="/home/yourdomain.com/public_html"

# Navigate to project directory
cd $SITE_PATH

echo "📥 Pulling latest changes from GitHub..."
git pull origin main

echo "📦 Installing/updating Composer dependencies..."
composer install --no-dev --optimize-autoloader

echo "🗄️  Running database migrations..."
php artisan migrate --force

echo "🧹 Clearing old cache..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

echo "⚡ Optimizing Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

echo "🔐 Setting permissions..."
chmod -R 775 storage bootstrap/cache
chown -R lscpd:lscpd storage bootstrap/cache

echo "🔄 Restarting LiteSpeed..."
systemctl restart lsws

echo "✅ Deployment completed successfully!"
echo "📅 Deployed at: $(date '+%Y-%m-%d %H:%M:%S')"
