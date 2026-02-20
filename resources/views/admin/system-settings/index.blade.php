@extends('layouts.admin')

@section('title', 'System Settings - EMANP')
@section('page-title', 'System Settings')
@section('page-subtitle', 'Configure system-wide settings and permissions')

@section('content')
@if(session('success'))
    <div class="bg-green-100 border-2 border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 border-2 border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
        <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- User Roles & Permissions -->
    <div class="bg-white rounded-xl border-2 border-gray-200 p-6">
        <h3 class="text-lg font-bold text-[#0F1B4C] mb-4">User Roles & Permissions</h3>
        <div class="space-y-4">
            <div class="p-4 bg-[#F7F9FC] rounded-lg">
                <h4 class="font-semibold text-[#0F1B4C] mb-2">Admin</h4>
                <p class="text-sm text-gray-600">Full system access, can manage all journals, users, and settings.</p>
            </div>
            <div class="p-4 bg-[#F7F9FC] rounded-lg">
                <h4 class="font-semibold text-[#0F1B4C] mb-2">Editor</h4>
                <p class="text-sm text-gray-600">Can manage submissions, assign reviewers, and make editorial decisions.</p>
            </div>
            <div class="p-4 bg-[#F7F9FC] rounded-lg">
                <h4 class="font-semibold text-[#0F1B4C] mb-2">Reviewer</h4>
                <p class="text-sm text-gray-600">Can review assigned manuscripts and provide feedback.</p>
            </div>
            <div class="p-4 bg-[#F7F9FC] rounded-lg">
                <h4 class="font-semibold text-[#0F1B4C] mb-2">Author</h4>
                <p class="text-sm text-gray-600">Can submit manuscripts and track their status.</p>
            </div>
        </div>
    </div>
    
    <!-- SMTP Settings -->
    <div class="bg-white rounded-xl border-2 border-gray-200 p-6">
        <h3 class="text-lg font-bold text-[#0F1B4C] mb-4 flex items-center">
            <i class="fas fa-envelope mr-2 text-[#0056FF]"></i>SMTP Settings
        </h3>
        <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-4 mb-4">
            <div class="flex items-start">
                <i class="fas fa-info-circle text-blue-600 mr-3 mt-1"></i>
                <div>
                    <p class="font-semibold text-blue-900 mb-1">CPanel SMTP Configuration</p>
                    <p class="text-sm text-blue-800">
                        For CPanel hosting, use your domain's mail server. Common settings:
                        <br>Host: mail.yourdomain.com or smtp.yourdomain.com
                        <br>Port: 587 (TLS) or 465 (SSL)
                        <br>Username: Your full email address
                        <br>Password: Your email account password
                    </p>
                </div>
            </div>
        </div>
        
        <form method="POST" action="{{ route('admin.system-settings.update-smtp') }}">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Mail Driver</label>
                    <select name="mail_driver" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                        <option value="smtp" {{ old('mail_driver', $emailSettings->mail_driver ?? 'smtp') == 'smtp' ? 'selected' : '' }}>SMTP</option>
                        <option value="sendmail" {{ old('mail_driver', $emailSettings->mail_driver ?? '') == 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">SMTP Host *</label>
                    <input type="text" name="mail_host" required 
                           value="{{ old('mail_host', $emailSettings->mail_host ?? '') }}"
                           placeholder="mail.yourdomain.com or smtp.yourdomain.com"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">SMTP Port *</label>
                    <input type="text" name="mail_port" required 
                           value="{{ old('mail_port', $emailSettings->mail_port ?? '587') }}"
                           placeholder="587 (TLS) or 465 (SSL)"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">SMTP Username</label>
                    <input type="text" name="mail_username" 
                           value="{{ old('mail_username', $emailSettings->mail_username ?? '') }}"
                           placeholder="your-email@yourdomain.com"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">SMTP Password</label>
                    <input type="password" name="mail_password" 
                           placeholder="Leave blank to keep current password"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Encryption *</label>
                    <select name="mail_encryption" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                        <option value="tls" {{ old('mail_encryption', $emailSettings->mail_encryption ?? 'tls') == 'tls' ? 'selected' : '' }}>TLS (Port 587)</option>
                        <option value="ssl" {{ old('mail_encryption', $emailSettings->mail_encryption ?? 'ssl') == 'ssl' ? 'selected' : '' }}>SSL (Port 465)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">From Email Address *</label>
                    <input type="email" name="mail_from_address" required 
                           value="{{ old('mail_from_address', $emailSettings->mail_from_address ?? '') }}"
                           placeholder="noreply@yourdomain.com"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">From Name *</label>
                    <input type="text" name="mail_from_name" required 
                           value="{{ old('mail_from_name', $emailSettings->mail_from_name ?? 'EMANP') }}"
                           placeholder="EMANP"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                </div>
            </div>
            <button type="submit" class="mt-4 w-full px-6 py-3 bg-[#0056FF] hover:bg-[#0044CC] text-white rounded-lg font-semibold transition-colors">
                <i class="fas fa-save mr-2"></i>Save SMTP Settings
            </button>
        </form>
        
        <!-- Test Email -->
        <div class="mt-6 pt-6 border-t border-gray-200">
            <h4 class="text-md font-semibold text-[#0F1B4C] mb-3">Test Email Configuration</h4>
            <form method="POST" action="{{ route('admin.system-settings.test-email') }}">
                @csrf
                <div class="flex gap-3">
                    <input type="email" name="test_email" required 
                           placeholder="Enter email to test"
                           class="flex-1 px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                    <button type="submit" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition-colors">
                        <i class="fas fa-paper-plane mr-2"></i>Send Test
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Storage Settings -->
    <div class="bg-white rounded-xl border-2 border-gray-200 p-6">
        <h3 class="text-lg font-bold text-[#0F1B4C] mb-4">Storage Settings</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Storage Driver</label>
                <select class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                    <option value="local">Local Storage</option>
                    <option value="s3">Amazon S3</option>
                    <option value="ftp">FTP</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Max File Size (MB)</label>
                <input type="number" value="10"
                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Allowed File Types</label>
                <input type="text" value="pdf,doc,docx"
                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
            </div>
        </div>
        <button class="mt-4 w-full px-6 py-3 bg-[#0056FF] hover:bg-[#0044CC] text-white rounded-lg font-semibold transition-colors">
            <i class="fas fa-save mr-2"></i>Save Storage Settings
        </button>
    </div>
    
    <!-- System Information -->
    <div class="bg-white rounded-xl border-2 border-gray-200 p-6">
        <h3 class="text-lg font-bold text-[#0F1B4C] mb-4">System Information</h3>
        <div class="space-y-3">
            <div class="flex justify-between">
                <span class="text-sm text-gray-600">Laravel Version</span>
                <span class="text-sm font-semibold text-[#0F1B4C]">{{ app()->version() }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-sm text-gray-600">PHP Version</span>
                <span class="text-sm font-semibold text-[#0F1B4C]">{{ PHP_VERSION }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-sm text-gray-600">Database</span>
                <span class="text-sm font-semibold text-[#0F1B4C]">{{ config('database.default') }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
