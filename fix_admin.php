<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "=== Admin User Fix Script ===\n\n";

// Get email from user or use default
$email = $argv[1] ?? 'admin@journal.com';
$password = $argv[2] ?? 'password';

echo "Email: {$email}\n";
echo "Password: {$password}\n\n";

$user = User::where('email', $email)->first();

if ($user) {
    echo "User found! Updating to admin...\n";
    $user->update([
        'role' => 'admin',
        'password' => Hash::make($password),
        'is_active' => true,
    ]);
    echo "✅ User updated successfully!\n";
    echo "   Role: {$user->role}\n";
    echo "   Email: {$user->email}\n";
} else {
    echo "User not found! Creating new admin user...\n";
    $user = User::create([
        'first_name' => 'Admin',
        'last_name' => 'User',
        'email' => $email,
        'password' => Hash::make($password),
        'role' => 'admin',
        'is_active' => true,
    ]);
    echo "✅ Admin user created successfully!\n";
    echo "   Email: {$user->email}\n";
    echo "   Role: {$user->role}\n";
}

echo "\n=== Login Credentials ===\n";
echo "Email: {$email}\n";
echo "Password: {$password}\n";
echo "\nYou can now login at: http://localhost:8000/login\n";
echo "After login, you'll be redirected to: http://localhost:8000/admin/dashboard\n";

