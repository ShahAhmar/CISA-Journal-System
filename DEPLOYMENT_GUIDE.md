# Shared Hosting Deployment Guide

## Folder Structure

```
/home/username/
├── public_html/          (Public folder contents)
│   ├── index.php
│   ├── .htaccess
│   ├── uploads/
│   └── ... (all public folder files)
│
└── laravel_app/          (Laravel application files)
    ├── app/
    ├── bootstrap/
    ├── config/
    ├── database/
    ├── resources/
    ├── routes/
    ├── storage/
    ├── vendor/
    ├── .env
    └── ... (all other Laravel files)
```

## Deployment Steps

### 1. Upload Files

**Upload public folder contents to `public_html`:**
- Copy all files from `public/` folder to `public_html/`
- Keep the folder structure intact (uploads, etc.)

**Upload Laravel files to `laravel_app`:**
- Copy all files EXCEPT `public/` folder to `laravel_app/`
- Include: app, bootstrap, config, database, resources, routes, storage, vendor, .env, etc.

### 2. Update public_html/index.php

The `index.php` file needs to point to `laravel_app` folder:

```php
<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../laravel_app/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../laravel_app/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
$app = require_once __DIR__.'/../laravel_app/bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
```

### 3. Update .env File

In `laravel_app/.env`, set:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Database settings
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 4. Set Permissions

Via SSH or File Manager, set permissions:

```bash
chmod -R 755 laravel_app/storage
chmod -R 755 laravel_app/bootstrap/cache
chmod -R 755 public_html/uploads
```

### 5. Run Migrations

Via SSH:

```bash
cd laravel_app
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 6. Create Storage Link (if needed)

```bash
cd laravel_app
php artisan storage:link
```

### 7. Update .htaccess in public_html

Ensure `.htaccess` exists in `public_html/`:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

## Important Notes

1. **Logo URLs**: The logo paths are already configured to use `asset()` helper which works correctly on shared hosting.

2. **File Uploads**: Files are stored in `public_html/uploads/` which is accessible directly.

3. **Storage**: Make sure `laravel_app/storage/` has write permissions.

4. **Cache**: After deployment, clear and rebuild caches:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   php artisan config:cache
   php artisan route:cache
   ```

5. **Email Settings**: Update email configuration in admin panel after deployment.

## Troubleshooting

- **500 Error**: Check file permissions and `.env` configuration
- **Logo not showing**: Verify `public_html/uploads/website/logo/` exists and has correct permissions
- **Routes not working**: Ensure `.htaccess` is in `public_html/` and mod_rewrite is enabled
- **Database connection**: Verify database credentials in `.env`

