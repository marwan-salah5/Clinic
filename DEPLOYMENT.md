# دليل النشر على VPS - Clinic System Deployment Guide

هذا الدليل يشرح كيفية نشر نظام العيادة على VPS وربطه بـ GitHub للنشر التلقائي.

## المتطلبات الأساسية

- VPS يعمل بنظام Ubuntu 20.04 أو أحدث
- صلاحيات root أو sudo
- حساب GitHub مع Personal Access Token

## الخطوة 1: الإعداد الأولي للـ VPS

### 1.1 رفع سكريبت النشر

قم برفع ملف `deploy-vps.sh` إلى VPS الخاص بك:

```bash
scp deploy-vps.sh username@your-vps-ip:/tmp/
```

### 1.2 تشغيل السكريبت

اتصل بـ VPS وشغل السكريبت:

```bash
ssh username@your-vps-ip
cd /tmp
chmod +x deploy-vps.sh
sudo ./deploy-vps.sh
```

> **ملاحظة مهمة:** السكريبت سيطبع SSH public key في نهاية التشغيل. احتفظ بهذا المفتاح للخطوة التالية.

### 1.3 تحديث إعدادات قاعدة البيانات

بعد انتهاء السكريبت، قم بتحديث كلمة مرور قاعدة البيانات:

```bash
sudo nano /var/www/clinic-system/.env
```

ابحث عن السطر `DB_PASSWORD` وضع كلمة مرور قوية:

```
DB_PASSWORD=your_secure_password_here
```

### 1.4 تحديث إعدادات Nginx

قم بتحديث اسم النطاق أو IP في ملف Nginx:

```bash
sudo nano /etc/nginx/sites-available/clinic-system
```

غير `YOUR_DOMAIN_OR_IP` إلى:
- اسم النطاق الخاص بك (مثل: `clinic.example.com`)
- أو IP الخاص بـ VPS (مثل: `123.45.67.89`)

ثم أعد تحميل Nginx:

```bash
sudo nginx -t
sudo systemctl reload nginx
```

## الخطوة 2: إعداد GitHub للنشر التلقائي

### 2.1 إضافة SSH Key إلى GitHub

1. اذهب إلى: https://github.com/marwan-salah5/Clinic/settings/keys
2. اضغط على "Add deploy key"
3. الصق المفتاح العام الذي ظهر في نهاية تشغيل السكريبت
4. سمي المفتاح "VPS Deployment"
5. **لا تفعل** خيار "Allow write access"

### 2.2 إضافة GitHub Secrets

اذهب إلى: https://github.com/marwan-salah5/Clinic/settings/secrets/actions

أضف الـ Secrets التالية:

#### `VPS_HOST`
- القيمة: IP الخاص بـ VPS (مثل: `123.45.67.89`)

#### `VPS_USERNAME`
- القيمة: `www-data`

#### `VPS_SSH_KEY`
- القيمة: محتوى الملف `/var/www/.ssh/id_ed25519` (المفتاح الخاص)
- للحصول على المفتاح الخاص، شغل على VPS:
  ```bash
  sudo cat /var/www/.ssh/id_ed25519
  ```
- انسخ **كل** محتوى الملف بما فيه السطر الأول والأخير

## الخطوة 3: اختبار النشر التلقائي

### 3.1 رفع الكود إلى GitHub

من جهازك المحلي:

```bash
cd /Users/marwansalah/Documents/عياده/clinic-system
git add .
git commit -m "Setup auto-deployment"
git push -u origin main
```

### 3.2 مراقبة عملية النشر

1. اذهب إلى: https://github.com/marwan-salah5/Clinic/actions
2. ستشاهد workflow يعمل تلقائياً
3. اضغط عليه لمشاهدة التفاصيل
4. انتظر حتى يكتمل بنجاح (علامة ✓ خضراء)

### 3.3 التحقق من النشر

افتح المتصفح واذهب إلى:
- `http://your-vps-ip` أو
- `http://your-domain.com`

يجب أن ترى صفحة تسجيل الدخول لنظام العيادة.

## كيفية عمل النشر التلقائي

بعد الإعداد الأولي، كل مرة تعمل `git push` إلى branch `main`:

1. GitHub Actions يشتغل تلقائياً
2. يتصل بـ VPS عن طريق SSH
3. يسحب آخر تحديثات من GitHub
4. يثبت/يحدث المكتبات المطلوبة
5. يشغل migrations لقاعدة البيانات
6. يحدث الـ cache
7. يعيد تحميل PHP-FPM و Nginx

**النتيجة:** التحديثات تظهر على VPS تلقائياً خلال دقائق!

## الأوامر المفيدة

### مشاهدة logs على VPS

```bash
# Laravel logs
sudo tail -f /var/www/clinic-system/storage/logs/laravel.log

# Nginx error logs
sudo tail -f /var/log/nginx/error.log

# PHP-FPM logs
sudo tail -f /var/log/php8.2-fpm.log
```

### إعادة تشغيل الخدمات

```bash
sudo systemctl restart php8.2-fpm
sudo systemctl restart nginx
sudo systemctl restart mysql
```

### النشر اليدوي (في حالة الطوارئ)

```bash
cd /var/www/clinic-system
sudo -u www-data git pull origin main
sudo -u www-data composer install --no-dev --optimize-autoloader
sudo -u www-data php artisan migrate --force
sudo -u www-data php artisan config:cache
sudo -u www-data php artisan route:cache
sudo -u www-data php artisan view:cache
sudo systemctl reload php8.2-fpm
sudo systemctl reload nginx
```

## استكشاف الأخطاء

### المشكلة: "Permission denied" عند git pull

**الحل:**
```bash
sudo chown -R www-data:www-data /var/www/clinic-system
```

### المشكلة: "500 Internal Server Error"

**الحل:**
```bash
# تحقق من الـ logs
sudo tail -f /var/www/clinic-system/storage/logs/laravel.log

# تأكد من الـ permissions
sudo chmod -R 775 /var/www/clinic-system/storage
sudo chmod -R 775 /var/www/clinic-system/bootstrap/cache
```

### المشكلة: GitHub Actions فشل

**الحل:**
1. تحقق من GitHub Secrets (VPS_HOST, VPS_USERNAME, VPS_SSH_KEY)
2. تأكد من SSH key مضاف لـ GitHub Deploy Keys
3. تحقق من أن www-data يستطيع الوصول لـ `/var/www/clinic-system`

## الأمان

> **تحذير:** لا تشارك أبداً:
> - محتوى ملف `.env`
> - المفتاح الخاص SSH (`id_ed25519`)
> - GitHub Secrets
> - كلمات مرور قاعدة البيانات

### توصيات أمنية إضافية

1. **استخدم HTTPS:** قم بتثبيت SSL certificate باستخدام Let's Encrypt:
   ```bash
   sudo apt install certbot python3-certbot-nginx
   sudo certbot --nginx -d your-domain.com
   ```

2. **قم بتحديث النظام بانتظام:**
   ```bash
   sudo apt update && sudo apt upgrade -y
   ```

3. **فعّل Firewall:**
   ```bash
   sudo ufw allow 22
   sudo ufw allow 80
   sudo ufw allow 443
   sudo ufw enable
   ```

## الدعم

إذا واجهت أي مشاكل:
1. تحقق من الـ logs (انظر قسم "الأوامر المفيدة")
2. راجع قسم "استكشاف الأخطاء"
3. تحقق من GitHub Actions logs
