# دليل النشر على CyberPanel - Clinic System Deployment Guide

## المقدمة

CyberPanel يوفر Git integration مدمج يخليك تربط موقعك بـ GitHub وتعمل تحديث تلقائي. الدليل ده هيوضحلك الخطوات بالتفصيل.

![CyberPanel Dashboard](/Users/marwansalah/.gemini/antigravity/brain/68617271-788d-4769-a526-fe3adb0f9f72/uploaded_image_1766578572640.png)

## الخطوة 1: إنشاء موقع جديد في CyberPanel

### 1.1 إضافة موقع جديد

1. من CyberPanel Dashboard، اذهب إلى **Websites** → **Create Website**
2. املأ البيانات:
   - **Domain Name**: اسم النطاق أو subdomain (مثل: `clinic.yourdomain.com`)
   - **Email**: بريدك الإلكتروني
   - **Package**: اختر الباقة المناسبة
   - **PHP Version**: اختر **PHP 8.2** (مهم جداً للـ Laravel)
3. اضغط **Create Website**

### 1.2 تفعيل SSL (اختياري لكن مهم)

1. اذهب إلى **SSL** → **Issue SSL**
2. اختر الموقع
3. اضغط **Issue SSL**

## الخطوة 2: ربط الموقع بـ GitHub

### 2.1 الدخول على Git Manager

1. من القائمة الجانبية، اذهب إلى **Version Management** أو **Git**
2. اختر **Create/Delete Git Repo**

### 2.2 إعداد Git Repository

1. **Select Website**: اختر الموقع اللي عملته
2. **Repository URL**: حط رابط GitHub repository:
   ```
   https://github.com/marwan-salah5/Clinic.git
   ```
3. **Branch**: اكتب `main`
4. **Repository Path**: خليها القيمة الافتراضية (عادة `/home/yourdomain/public_html`)

### 2.3 إضافة GitHub Personal Access Token

لو CyberPanel طلب منك authentication:

1. استخدم Personal Access Token اللي عملته قبل كده
2. **Username**: `marwan-salah5`
3. **Password/Token**: الصق الـ Personal Access Token

> **ملاحظة:** لو مش فاكر الـ token، ممكن تعمل واحد جديد من:
> https://github.com/settings/tokens/new

4. اضغط **Create Repository** أو **Clone**

## الخطوة 3: إعداد Laravel على CyberPanel

بعد ما الكود يتنزل، لازم نعمل setup للـ Laravel:

### 3.1 الدخول على Terminal عن طريق CyberPanel

1. من القائمة الجانبية، اذهب إلى **Terminal** أو استخدم SSH:
   ```bash
   ssh root@148.230.107.102
   ```

### 3.2 الانتقال لمجلد الموقع

```bash
cd /home/yourdomain.com/public_html
```

> **ملاحظة:** غير `yourdomain.com` باسم الموقع الفعلي

### 3.3 تثبيت Composer Dependencies

```bash
composer install --no-dev --optimize-autoloader
```

### 3.4 إعداد Environment File

```bash
cp .env.example .env
php artisan key:generate
```

### 3.5 تعديل ملف .env

افتح ملف `.env` وعدل إعدادات قاعدة البيانات:

```bash
nano .env
```

عدل الأسطر دي:

```env
APP_NAME="عيادات القافلة الطبية"
APP_ENV=production
APP_DEBUG=false
APP_URL=http://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=clinic_db
DB_USERNAME=clinic_user
DB_PASSWORD=your_secure_password
```

احفظ الملف (Ctrl+X ثم Y ثم Enter)

### 3.6 إنشاء قاعدة البيانات

من CyberPanel:

1. اذهب إلى **Databases** → **Create Database**
2. **Database Name**: `clinic_db`
3. **Username**: `clinic_user`
4. **Password**: حط كلمة مرور قوية (نفس اللي في `.env`)
4. اضغط **Create Database**

### 3.7 تشغيل Migrations

```bash
php artisan migrate --force --seed
```

### 3.8 ضبط الـ Permissions

```bash
chmod -R 775 storage bootstrap/cache
chown -R lscpd:lscpd storage bootstrap/cache
```

### 3.9 تحسين Laravel

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

## الخطوة 4: ضبط Document Root

Laravel يحتاج Document Root يكون على مجلد `public`:

### 4.1 من CyberPanel UI

1. اذهب إلى **Websites** → **List Websites**
2. اختر موقعك
3. اضغط على **Modify Website**
4. في **Document Root**، غيره من:
   ```
   /home/yourdomain.com/public_html
   ```
   إلى:
   ```
   /home/yourdomain.com/public_html/public
   ```
5. احفظ التغييرات

### 4.2 إعادة تشغيل LiteSpeed

```bash
systemctl restart lsws
```

## الخطوة 5: إعداد Auto-Deployment من GitHub

### الطريقة 1: استخدام CyberPanel Git Manager (الأسهل)

1. من **Version Management** → **Git**
2. اختر موقعك
3. اضغط **Pull Changes** كل ما تحتاج تحديث

### الطريقة 2: GitHub Webhook (تلقائي)

#### 5.1 إنشاء Deployment Script

أنشئ ملف في مجلد الموقع:

```bash
nano /home/yourdomain.com/deploy.sh
```

الصق المحتوى ده:

```bash
#!/bin/bash

# Navigate to project directory
cd /home/yourdomain.com/public_html

# Pull latest changes
git pull origin main

# Install/update dependencies
composer install --no-dev --optimize-autoloader

# Run migrations
php artisan migrate --force

# Clear and cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Fix permissions
chmod -R 775 storage bootstrap/cache
chown -R lscpd:lscpd storage bootstrap/cache

# Restart LiteSpeed
systemctl restart lsws

echo "Deployment completed successfully!"
```

اعمل الملف executable:

```bash
chmod +x /home/yourdomain.com/deploy.sh
```

#### 5.2 إنشاء Webhook Endpoint

أنشئ ملف PHP في مجلد `public`:

```bash
nano /home/yourdomain.com/public_html/public/deploy.php
```

الصق المحتوى ده:

```php
<?php

// GitHub Webhook Secret (اختياري للأمان)
$secret = 'YOUR_WEBHOOK_SECRET_HERE';

// Verify GitHub signature (اختياري)
if (isset($_SERVER['HTTP_X_HUB_SIGNATURE'])) {
    $payload = file_get_contents('php://input');
    $signature = 'sha1=' . hash_hmac('sha1', $payload, $secret);
    
    if (!hash_equals($signature, $_SERVER['HTTP_X_HUB_SIGNATURE'])) {
        http_response_code(403);
        die('Invalid signature');
    }
}

// Run deployment script
$output = shell_exec('/home/yourdomain.com/deploy.sh 2>&1');

// Log the deployment
file_put_contents('/home/yourdomain.com/deployment.log', date('Y-m-d H:i:s') . "\n" . $output . "\n\n", FILE_APPEND);

echo "Deployment triggered successfully!";
```

#### 5.3 إضافة Webhook في GitHub

1. اذهب إلى: https://github.com/marwan-salah5/Clinic/settings/hooks
2. اضغط **Add webhook**
3. **Payload URL**: `http://yourdomain.com/deploy.php`
4. **Content type**: `application/json`
5. **Secret**: نفس القيمة في `deploy.php` (اختياري)
6. **Which events**: اختر `Just the push event`
7. اضغط **Add webhook**

### الطريقة 3: Cron Job (تحديث دوري)

لو عايز الموقع يتحدث تلقائياً كل فترة:

```bash
crontab -e
```

أضف السطر ده (تحديث كل 5 دقائق):

```
*/5 * * * * /home/yourdomain.com/deploy.sh >> /home/yourdomain.com/deployment.log 2>&1
```

## الخطوة 6: التحديث اليدوي (في أي وقت)

لو عايز تعمل تحديث يدوي:

### من Terminal

```bash
cd /home/yourdomain.com/public_html
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan optimize
systemctl restart lsws
```

### أو استخدم الـ Script

```bash
/home/yourdomain.com/deploy.sh
```

### أو من CyberPanel UI

1. **Version Management** → **Git**
2. اختر موقعك
3. **Pull Changes**

## استكشاف الأخطاء

### المشكلة: "500 Internal Server Error"

**الحل:**

```bash
# تحقق من الـ logs
tail -f /usr/local/lsws/logs/error.log
tail -f /home/yourdomain.com/public_html/storage/logs/laravel.log

# تأكد من الـ permissions
chmod -R 775 /home/yourdomain.com/public_html/storage
chmod -R 775 /home/yourdomain.com/public_html/bootstrap/cache
chown -R lscpd:lscpd /home/yourdomain.com/public_html
```

### المشكلة: "Git pull failed"

**الحل:**

```bash
# تحقق من Git status
cd /home/yourdomain.com/public_html
git status

# لو في conflicts، reset للـ local changes
git reset --hard origin/main
```

### المشكلة: "Composer not found"

**الحل:**

```bash
# تثبيت Composer
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
chmod +x /usr/local/bin/composer
```

### المشكلة: "PHP version مش مظبوط"

**الحل:**

1. من CyberPanel: **Websites** → **List Websites**
2. اختر موقعك → **Modify Website**
3. غير **PHP Version** لـ **8.2**

## الأوامر المفيدة

### مشاهدة Logs

```bash
# Laravel logs
tail -f /home/yourdomain.com/public_html/storage/logs/laravel.log

# LiteSpeed error logs
tail -f /usr/local/lsws/logs/error.log

# Deployment logs (لو استخدمت webhook)
tail -f /home/yourdomain.com/deployment.log
```

### إعادة تشغيل الخدمات

```bash
# إعادة تشغيل LiteSpeed
systemctl restart lsws

# إعادة تشغيل MySQL
systemctl restart mysql
```

### تنظيف Cache

```bash
cd /home/yourdomain.com/public_html
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## الأمان

> [!WARNING]
> **مهم جداً للأمان:**

1. **احمي ملف deploy.php:**
   - استخدم webhook secret قوي
   - أو امسح الملف لو مش هتستخدم webhooks

2. **لا تشارك أبداً:**
   - محتوى ملف `.env`
   - كلمات مرور قاعدة البيانات
   - GitHub Personal Access Token

3. **استخدم HTTPS:**
   - فعّل SSL من CyberPanel
   - غير `APP_URL` في `.env` لـ `https://`

## ملخص سريع

```bash
# 1. Clone من GitHub (من CyberPanel UI)
# 2. Setup Laravel
cd /home/yourdomain.com/public_html
composer install --no-dev --optimize-autoloader
cp .env.example .env
php artisan key:generate
nano .env  # عدل إعدادات DB

# 3. Database
# أنشئ من CyberPanel UI

# 4. Migrate
php artisan migrate --force --seed

# 5. Permissions
chmod -R 775 storage bootstrap/cache
chown -R lscpd:lscpd storage bootstrap/cache

# 6. Optimize
php artisan optimize

# 7. غير Document Root لـ /public
# من CyberPanel UI

# 8. Restart
systemctl restart lsws
```

## الدعم

لو واجهت أي مشاكل:
1. تحقق من الـ logs
2. راجع قسم "استكشاف الأخطاء"
3. تأكد من PHP version = 8.2
4. تأكد من Document Root = `/public`
