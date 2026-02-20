@extends('layouts.admin')

@section('title', 'Website Settings - EMANP')
@section('page-title', 'Website Settings')
@section('page-subtitle', 'Configure homepage, logo, footer, and contact information')

@section('content')
@if(session('success'))
    <div class="bg-green-100 border-2 border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
        {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <form method="POST" action="{{ route('admin.website-settings.update') }}" enctype="multipart/form-data">
            @csrf
            
        <!-- Homepage Settings -->
        <div class="bg-white rounded-xl border-2 border-gray-200 p-6">
            <h3 class="text-lg font-bold text-[#0F1B4C] mb-4">Homepage Settings</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Homepage Title</label>
                        <input type="text" name="homepage_title" value="{{ old('homepage_title', $settings->homepage_title ?? 'EMANP - Excellence in Management & Academic Network Publishing') }}"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Homepage Description</label>
                        <textarea name="homepage_description" rows="4" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">{{ old('homepage_description', $settings->homepage_description ?? 'A multi-journal academic platform for high-quality peer-reviewed research.') }}</textarea>
                </div>
            </div>
        </div>
        
        <!-- Logo Settings -->
        <div class="bg-white rounded-xl border-2 border-gray-200 p-6">
            <h3 class="text-lg font-bold text-[#0F1B4C] mb-4">Logo Settings</h3>
            <div class="space-y-4">
                    @if($settings->logo)
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Current Logo</label>
                            <div class="border-2 border-gray-200 rounded-lg p-4 bg-gray-50">
                                @php
                                    $logoPath = $settings->logo;
                                    if (strpos($logoPath, 'uploads/') === 0) {
                                        $logoUrl = asset($logoPath);
                                    } else {
                                        $logoUrl = asset('storage/' . $logoPath);
                                    }
                                @endphp
                                <img src="{{ $logoUrl }}" alt="Current Logo" class="h-24 w-auto object-contain">
                            </div>
                        </div>
                    @endif
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Upload Logo</label>
                        <input type="file" name="logo" accept="image/jpeg,image/jpg,image/png,image/gif,image/webp" 
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                        <p class="text-xs text-gray-500 mt-2">
                            <i class="fas fa-info-circle mr-1"></i>Recommended: Square image (500x500px). Max: 5MB
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Upload Favicon</label>
                        <input type="file" name="favicon" accept="image/ico,image/png" 
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                        <p class="text-xs text-gray-500 mt-2">
                            <i class="fas fa-info-circle mr-1"></i>Recommended: 32x32px or 16x16px. Max: 1MB
                        </p>
                </div>
            </div>
        </div>
        
        <!-- Footer Settings -->
        <div class="bg-white rounded-xl border-2 border-gray-200 p-6">
            <h3 class="text-lg font-bold text-[#0F1B4C] mb-4">Footer Settings</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Footer Text</label>
                        <textarea name="footer_text" rows="3" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">{{ old('footer_text', $settings->footer_text ?? '© 2025 EMANP - Excellence in Management & Academic Network Publishing. All rights reserved.') }}</textarea>
                </div>
            </div>
        </div>
        
        <!-- Contact Information -->
        <div class="bg-white rounded-xl border-2 border-gray-200 p-6">
            <h3 class="text-lg font-bold text-[#0F1B4C] mb-4">Contact Information</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                        <input type="email" name="contact_email" value="{{ old('contact_email', $settings->contact_email ?? '') }}"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Phone</label>
                        <input type="text" name="contact_phone" value="{{ old('contact_phone', $settings->contact_phone ?? '') }}"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Address</label>
                        <textarea name="contact_address" rows="3" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">{{ old('contact_address', $settings->contact_address ?? '') }}</textarea>
                </div>
            </div>
        </div>
        
        <!-- Social Links -->
        <div class="bg-white rounded-xl border-2 border-gray-200 p-6">
            <h3 class="text-lg font-bold text-[#0F1B4C] mb-4">Social Media Links</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Facebook</label>
                        <input type="url" name="facebook_url" value="{{ old('facebook_url', $settings->facebook_url ?? '') }}" placeholder="https://facebook.com/..."
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Twitter</label>
                        <input type="url" name="twitter_url" value="{{ old('twitter_url', $settings->twitter_url ?? '') }}" placeholder="https://twitter.com/..."
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">LinkedIn</label>
                        <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $settings->linkedin_url ?? '') }}" placeholder="https://linkedin.com/..."
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                </div>
            </div>
        </div>
        
        <div class="flex justify-end">
                <button type="submit" class="px-8 py-3 bg-[#0056FF] hover:bg-[#0044CC] text-white rounded-lg font-semibold transition-colors">
                <i class="fas fa-save mr-2"></i>Save Settings
            </button>
        </div>
        </form>
    </div>
    
    <div>
        <div class="bg-white rounded-xl border-2 border-gray-200 p-6 sticky top-6">
            <h3 class="text-lg font-bold text-[#0F1B4C] mb-4">Quick Actions</h3>
            <div class="space-y-3">
                <a href="{{ route('journals.index') }}" target="_blank" class="block w-full bg-[#F7F9FC] hover:bg-[#0056FF] hover:text-white text-[#0F1B4C] px-4 py-3 rounded-lg font-semibold transition-colors text-center">
                    <i class="fas fa-external-link-alt mr-2"></i>View Website
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

