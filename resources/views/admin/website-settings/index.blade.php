@extends('layouts.admin')

@section('title', 'Website Settings - CISA')
@section('page-title', 'Website Settings')
@section('page-subtitle', 'Configure homepage, branding, and platform information')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            <form method="POST" action="{{ route('admin.website-settings.update') }}" enctype="multipart/form-data">
                @csrf

                <!-- Homepage Settings -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
                    <div class="bg-slate-50 border-b border-gray-100 px-8 py-5">
                        <h3 class="font-bold text-cisa-base flex items-center gap-2">
                            <i class="fas fa-home text-cisa-accent"></i> Homepage Settings
                        </h3>
                    </div>
                    <div class="p-8 space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Homepage Title</label>
                            <input type="text" name="homepage_title"
                                value="{{ old('homepage_title', $settings->homepage_title ?? 'CISA Interdisciplinary Journal - Premier Academic Publishing Platform') }}"
                                class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all">
                            <p class="text-xs text-gray-400 mt-2">
                                <i class="fas fa-info-circle mr-1"></i>Appears in browser tab and search results
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Homepage Description</label>
                            <textarea name="homepage_description" rows="4"
                                class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all">{{ old('homepage_description', $settings->homepage_description ?? 'Access thousands of peer-reviewed articles across multiple disciplines. Accelerate your research journey with our world-class academic publishing platform.') }}</textarea>
                            <p class="text-xs text-gray-400 mt-2">
                                <i class="fas fa-info-circle mr-1"></i>Used for SEO and social media previews
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
                    <div class="bg-slate-50 border-b border-gray-100 px-8 py-5">
                        <h3 class="font-bold text-cisa-base flex items-center gap-2">
                            <i class="fas fa-address-card text-cisa-accent"></i> Contact Information
                        </h3>
                    </div>
                    <div class="p-8 space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Email Address</label>
                            <input type="email" name="contact_email"
                                value="{{ old('contact_email', $settings->contact_email ?? '') }}"
                                class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all"
                                placeholder="contact@cisa-journal.org">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Phone Number</label>
                            <input type="text" name="contact_phone"
                                value="{{ old('contact_phone', $settings->contact_phone ?? '') }}"
                                class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all"
                                placeholder="+1 (555) 123-4567">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Physical Address</label>
                            <textarea name="contact_address" rows="3"
                                class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all"
                                placeholder="123 Research Avenue, Academic City, AC 12345">{{ old('contact_address', $settings->contact_address ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit"
                        class="px-8 py-3 bg-cisa-accent hover:bg-amber-600 text-white rounded-lg font-bold shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all flex items-center">
                        <i class="fas fa-save mr-2"></i>Save All Settings
                    </button>
                </div>
            </form>
        </div>

        <div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-6">
                <h3 class="font-bold text-cisa-base mb-6 flex items-center gap-2">
                    <i class="fas fa-bolt text-cisa-accent"></i> Quick Actions
                </h3>

                <div class="space-y-3">
                    <a href="{{ route('journals.index') }}" target="_blank"
                        class="block w-full bg-slate-50 hover:bg-cisa-base text-gray-700 hover:text-white px-4 py-3 rounded-lg font-bold transition-all text-center flex items-center justify-center border border-gray-200">
                        <i class="fas fa-external-link-alt mr-2"></i>View Live Website
                    </a>

                    <a href="{{ route('admin.dashboard') }}"
                        class="block w-full bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-3 rounded-lg font-bold transition-all text-center flex items-center justify-center">
                        <i class="fas fa-tachometer-alt mr-2"></i>Admin Dashboard
                    </a>

                    <div class="pt-4 border-t border-gray-200">
                        <h4 class="text-sm font-bold text-gray-700 mb-2">Need Help?</h4>
                        <p class="text-xs text-gray-500 mb-2">Changes may take a few minutes to appear on the live site.</p>
                        <p class="text-xs text-gray-500">Contact support if you experience any issues.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection