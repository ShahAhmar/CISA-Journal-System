@extends('layouts.admin')

@section('title', 'System Settings - CISA')
@section('page-title', 'System Settings')
@section('page-subtitle', 'Configure system-wide settings and email configuration')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- SMTP Settings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-slate-50 border-b border-gray-100 px-8 py-5">
                <h3 class="font-bold text-cisa-base flex items-center gap-2">
                    <i class="fas fa-envelope text-cisa-accent"></i> SMTP Email Settings
                </h3>
            </div>

            <div class="p-8">
                <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 mb-6">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-info-circle text-blue-600 mt-1"></i>
                        <div>
                            <p class="font-bold text-blue-900 text-sm mb-1">CPanel SMTP Configuration</p>
                            <p class="text-xs text-blue-800 leading-relaxed">
                                Host: mail.yourdomain.com or smtp.yourdomain.com<br>
                                Port: 587 (TLS) or 465 (SSL)<br>
                                Username: Your full email address<br>
                                Password: Your email account password
                            </p>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.system-settings.update-smtp') }}">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Mail Driver</label>
                            <select name="mail_driver" required
                                class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all">
                                <option value="smtp" {{ old('mail_driver', $emailSettings->mail_driver ?? 'smtp') == 'smtp' ? 'selected' : '' }}>SMTP</option>
                                <option value="sendmail" {{ old('mail_driver', $emailSettings->mail_driver ?? '') == 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">SMTP Host <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="mail_host" required
                                value="{{ old('mail_host', $emailSettings->mail_host ?? '') }}"
                                placeholder="mail.yourdomain.com"
                                class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">SMTP Port <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="mail_port" required
                                value="{{ old('mail_port', $emailSettings->mail_port ?? '587') }}" placeholder="587"
                                class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">SMTP Username</label>
                            <input type="text" name="mail_username"
                                value="{{ old('mail_username', $emailSettings->mail_username ?? '') }}"
                                placeholder="your-email@yourdomain.com"
                                class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">SMTP Password</label>
                            <input type="password" name="mail_password" placeholder="Leave blank to keep current"
                                class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Encryption <span
                                    class="text-red-500">*</span></label>
                            <select name="mail_encryption" required
                                class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all">
                                <option value="tls" {{ old('mail_encryption', $emailSettings->mail_encryption ?? 'tls') == 'tls' ? 'selected' : '' }}>TLS (Port 587)</option>
                                <option value="ssl" {{ old('mail_encryption', $emailSettings->mail_encryption ?? 'ssl') == 'ssl' ? 'selected' : '' }}>SSL (Port 465)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">From Email <span
                                    class="text-red-500">*</span></label>
                            <input type="email" name="mail_from_address" required
                                value="{{ old('mail_from_address', $emailSettings->mail_from_address ?? '') }}"
                                placeholder="noreply@yourdomain.com"
                                class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">From Name <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="mail_from_name" required
                                value="{{ old('mail_from_name', $emailSettings->mail_from_name ?? 'CISA Journal') }}"
                                placeholder="CISA Journal"
                                class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all">
                        </div>
                    </div>
                    <button type="submit"
                        class="mt-6 w-full px-6 py-3 bg-cisa-accent hover:bg-amber-600 text-white rounded-lg font-bold shadow-lg hover:shadow-xl transition-all">
                        <i class="fas fa-save mr-2"></i>Save SMTP Settings
                    </button>
                </form>

                <!-- Test Email -->
                <div class="mt-6 pt-6 border-t border-gray-100">
                    <h4 class="text-sm font-bold text-gray-700 mb-3">Test Email Configuration</h4>
                    <form method="POST" action="{{ route('admin.system-settings.test-email') }}">
                        @csrf
                        <div class="flex gap-3">
                            <input type="email" name="test_email" required placeholder="Enter email to test"
                                class="flex-1 px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:outline-none focus:border-cisa-accent">
                            <button type="submit"
                                class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-bold transition-colors">
                                <i class="fas fa-paper-plane mr-2"></i>Send Test
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- User Roles & Permissions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-slate-50 border-b border-gray-100 px-8 py-5">
                <h3 class="font-bold text-cisa-base flex items-center gap-2">
                    <i class="fas fa-users-cog text-cisa-accent"></i> User Roles & Permissions
                </h3>
            </div>
            <div class="p-8 space-y-4">
                <div class="p-4 bg-slate-50 rounded-lg border border-gray-100">
                    <h4 class="font-bold text-cisa-base mb-1 text-sm">Admin</h4>
                    <p class="text-xs text-gray-600">Full system access, can manage all journals, users, and settings.</p>
                </div>
                <div class="p-4 bg-slate-50 rounded-lg border border-gray-100">
                    <h4 class="font-bold text-cisa-base mb-1 text-sm">Editor</h4>
                    <p class="text-xs text-gray-600">Can manage submissions, assign reviewers, and make editorial decisions.
                    </p>
                </div>
                <div class="p-4 bg-slate-50 rounded-lg border border-gray-100">
                    <h4 class="font-bold text-cisa-base mb-1 text-sm">Reviewer</h4>
                    <p class="text-xs text-gray-600">Can review assigned manuscripts and provide feedback.</p>
                </div>
                <div class="p-4 bg-slate-50 rounded-lg border border-gray-100">
                    <h4 class="font-bold text-cisa-base mb-1 text-sm">Author</h4>
                    <p class="text-xs text-gray-600">Can submit manuscripts and track their status.</p>
                </div>
            </div>
        </div>

        <!-- Storage Settings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-slate-50 border-b border-gray-100 px-8 py-5">
                <h3 class="font-bold text-cisa-base flex items-center gap-2">
                    <i class="fas fa-hdd text-cisa-accent"></i> Storage Settings
                </h3>
            </div>
            <div class="p-8">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Storage Driver</label>
                        <select
                            class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:outline-none focus:border-cisa-accent">
                            <option value="local">Local Storage</option>
                            <option value="s3">Amazon S3</option>
                            <option value="ftp">FTP</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Max File Size (MB)</label>
                        <input type="number" value="10"
                            class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:outline-none focus:border-cisa-accent">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Allowed File Types</label>
                        <input type="text" value="pdf,doc,docx"
                            class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:outline-none focus:border-cisa-accent">
                    </div>
                </div>
                <button
                    class="mt-6 w-full px-6 py-3 bg-cisa-accent hover:bg-amber-600 text-white rounded-lg font-bold shadow-lg hover:shadow-xl transition-all">
                    <i class="fas fa-save mr-2"></i>Save Storage Settings
                </button>
            </div>
        </div>

        <!-- System Information -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-slate-50 border-b border-gray-100 px-8 py-5">
                <h3 class="font-bold text-cisa-base flex items-center gap-2">
                    <i class="fas fa-server text-cisa-accent"></i> System Information
                </h3>
            </div>
            <div class="p-8 space-y-3">
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-sm text-gray-600">Laravel Version</span>
                    <span class="text-sm font-bold text-cisa-base">{{ app()->version() }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-sm text-gray-600">PHP Version</span>
                    <span class="text-sm font-bold text-cisa-base">{{ PHP_VERSION }}</span>
                </div>
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm text-gray-600">Database</span>
                    <span class="text-sm font-bold text-cisa-base">{{ config('database.default') }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection