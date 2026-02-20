<?php
/**
 * Simple Cache Clear Script for Shared Hosting
 * 
 * IMPORTANT: Delete this file after use for security!
 * 
 * Usage: Visit http://yourdomain.com/clear-cache-simple.php?key=YOUR_SECRET_KEY
 */

// Security check
$secretKey = 'abc123'; // YEH LINE EDIT KARO - APNA SECRET KEY DALO

if (!isset($_GET['key']) || $_GET['key'] !== $secretKey) {
    die('Access denied. Add ?key=YOUR_SECRET_KEY to URL');
}

echo "<h2>Clearing Laravel Caches...</h2>";
echo "<pre>";

// Get project root (one level up from public)
$rootPath = dirname(__DIR__);
$cachePath = $rootPath . '/bootstrap/cache';

// Function to delete file if exists
function deleteFile($path) {
    if (file_exists($path)) {
        if (unlink($path)) {
            return true;
        } else {
            return false;
        }
    }
    return null; // File doesn't exist
}

// Clear route cache files
$routeFiles = [
    $cachePath . '/routes-v7.php',
    $cachePath . '/routes.php',
    $cachePath . '/routes-v6.php',
];

echo "Checking route cache files...\n";
foreach ($routeFiles as $file) {
    $result = deleteFile($file);
    if ($result === true) {
        echo "✓ Deleted: " . basename($file) . "\n";
    } elseif ($result === false) {
        echo "✗ Failed to delete: " . basename($file) . "\n";
    }
}

// Clear config cache
$configFile = $cachePath . '/config.php';
$result = deleteFile($configFile);
if ($result === true) {
    echo "✓ Deleted: config.php\n";
} elseif ($result === false) {
    echo "✗ Failed to delete: config.php\n";
} elseif ($result === null) {
    echo "ℹ config.php not found (already cleared)\n";
}

// Clear services cache
$servicesFile = $cachePath . '/services.php';
$result = deleteFile($servicesFile);
if ($result === true) {
    echo "✓ Deleted: services.php\n";
} elseif ($result === null) {
    echo "ℹ services.php not found (already cleared)\n";
}

// Try to clear Laravel cache using Artisan (if possible)
try {
    // Load Laravel
    require $rootPath . '/vendor/autoload.php';
    $app = require_once $rootPath . '/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    // Clear application cache
    try {
        Artisan::call('cache:clear');
        echo "✓ Application cache cleared via Artisan\n";
    } catch (Exception $e) {
        echo "⚠ Application cache clear failed: " . $e->getMessage() . "\n";
    }
    
    // Clear view cache
    try {
        Artisan::call('view:clear');
        echo "✓ View cache cleared via Artisan\n";
    } catch (Exception $e) {
        echo "⚠ View cache clear failed: " . $e->getMessage() . "\n";
    }
    
} catch (Exception $e) {
    echo "⚠ Laravel bootstrap failed: " . $e->getMessage() . "\n";
    echo "   (This is okay - cache files were still deleted manually)\n";
}

echo "\n✅ Cache clearing process completed!\n";
echo "\n⚠️ IMPORTANT: Delete this file (clear-cache-simple.php) now for security!\n";
echo "\n📝 Next steps:\n";
echo "1. Refresh your website\n";
echo "2. Test if export routes work now\n";
echo "3. Delete this script file\n";

echo "</pre>";
?>


