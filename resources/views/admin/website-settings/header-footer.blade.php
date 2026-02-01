@extends('layouts.admin')

@section('title', 'Header & Footer Settings - CISA')
@section('page-title', 'Header & Footer Settings')
@section('page-subtitle', 'Manage website branding, navigation, and footer content')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            <form method="POST" action="{{ route('admin.website-settings.update-header-footer') }}"
                enctype="multipart/form-data">
                @csrf

                <!-- HEADER SECTION -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div
                        class="bg-slate-800 text-white px-8 py-4 border-b border-slate-700 flex justify-between items-center">
                        <h3 class="font-bold text-lg flex items-center gap-2">
                            <i class="fas fa-heading text-cisa-accent"></i> Header Configuration
                        </h3>
                        <span class="text-xs bg-slate-700 px-2 py-1 rounded text-slate-300">Section 1</span>
                    </div>
                    <div class="p-8 space-y-6">
                        @if($settings->logo)
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Current Website Logo</label>
                                <div class="border border-gray-200 rounded-xl p-6 bg-slate-50 flex items-center justify-center">
                                    @php
                                        $logoPath = $settings->logo;
                                        if (strpos($logoPath, 'uploads/') === 0) {
                                            $logoUrl = asset($logoPath);
                                        } else {
                                            $logoUrl = asset('storage/' . $logoPath);
                                        }
                                    @endphp
                                    <img src="{{ $logoUrl }}" alt="Current Logo" class="h-16 w-auto object-contain">
                                </div>
                            </div>
                        @endif

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Upload New Logo</label>
                            <input type="file" name="logo" accept="image/jpeg,image/jpg,image/png,image/gif,image/webp"
                                class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:outline-none focus:border-cisa-accent transition-all">
                            <p class="text-xs text-gray-400 mt-2">
                                <i class="fas fa-info-circle mr-1"></i>Appears in Header and Footer. Recommended:
                                Transparent PNG, max 5MB.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- FOOTER SECTION -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div
                        class="bg-slate-800 text-white px-8 py-4 border-b border-slate-700 flex justify-between items-center">
                        <h3 class="font-bold text-lg flex items-center gap-2">
                            <i class="fas fa-shoe-prints text-cisa-accent"></i> Footer Configuration
                        </h3>
                        <span class="text-xs bg-slate-700 px-2 py-1 rounded text-slate-300">Section 2</span>
                    </div>

                    <div class="p-6 bg-slate-50 border-b border-gray-200">
                        <p class="text-sm text-gray-600">
                            Configure the 4 columns of the footer. Use the fields below to customize titles, text, and
                            links.
                        </p>
                    </div>

                    <div class="p-8 space-y-8">
                        <!-- Column 1: Brand & Description -->
                        <div class="border border-gray-200 rounded-lg p-5 relative">
                            <div
                                class="absolute -top-3 left-4 bg-white px-2 text-xs font-bold text-cisa-base uppercase tracking-wider">
                                Column 1: Brand & About
                            </div>
                            <div class="space-y-4 pt-2">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Footer Description</label>
                                    <textarea name="footer_description" rows="3"
                                        class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all"
                                        placeholder="Brief text about the journal appearing under the logo...">{{ old('footer_description', $settings->footer_description ?? 'Excellence in Management & Academic Network Publishing. Advancing global knowledge through open-access research.') }}</textarea>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-2">Support Button
                                            Text</label>
                                        <input type="text" name="support_button_text"
                                            value="{{ old('support_button_text', $settings->support_button_text ?? 'Support African Research') }}"
                                            class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-2">Support Button URL</label>
                                        <input type="text" name="support_button_url"
                                            value="{{ old('support_button_url', $settings->support_button_url ?? '#') }}"
                                            class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Column 2 & 3: Navigation Links -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="border border-gray-200 rounded-lg p-5 relative">
                                <div
                                    class="absolute -top-3 left-4 bg-white px-2 text-xs font-bold text-cisa-base uppercase tracking-wider">
                                    Column 2
                                </div>
                                <div class="pt-2">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Section Title</label>
                                    <input type="text" name="footer_section_1_title"
                                        value="{{ old('footer_section_1_title', $settings->footer_section_1_title ?? 'Resources') }}"
                                        class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all">
                                    <p class="text-xs text-gray-400 mt-2">Links are managed via system routes.</p>
                                </div>
                            </div>

                            <div class="border border-gray-200 rounded-lg p-5 relative">
                                <div
                                    class="absolute -top-3 left-4 bg-white px-2 text-xs font-bold text-cisa-base uppercase tracking-wider">
                                    Column 3
                                </div>
                                <div class="pt-2">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Section Title</label>
                                    <input type="text" name="footer_section_2_title"
                                        value="{{ old('footer_section_2_title', $settings->footer_section_2_title ?? 'Journals') }}"
                                        class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all">
                                    <p class="text-xs text-gray-400 mt-2">Links are managed via system routes.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Column 4: Contact & Social -->
                        <div class="border border-gray-200 rounded-lg p-5 relative">
                            <div
                                class="absolute -top-3 left-4 bg-white px-2 text-xs font-bold text-cisa-base uppercase tracking-wider">
                                Column 4: Contact & Social
                            </div>
                            <div class="pt-2 space-y-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Section Title</label>
                                    <input type="text" name="footer_section_3_title"
                                        value="{{ old('footer_section_3_title', $settings->footer_section_3_title ?? 'Contact') }}"
                                        class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all">
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 mb-1">Facebook URL</label>
                                        <input type="url" name="facebook_url"
                                            value="{{ old('facebook_url', $settings->facebook_url ?? '') }}"
                                            class="w-full px-3 py-2 bg-slate-50 border border-gray-200 rounded text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 mb-1">Twitter/X URL</label>
                                        <input type="url" name="twitter_url"
                                            value="{{ old('twitter_url', $settings->twitter_url ?? '') }}"
                                            class="w-full px-3 py-2 bg-slate-50 border border-gray-200 rounded text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 mb-1">LinkedIn URL</label>
                                        <input type="url" name="linkedin_url"
                                            value="{{ old('linkedin_url', $settings->linkedin_url ?? '') }}"
                                            class="w-full px-3 py-2 bg-slate-50 border border-gray-200 rounded text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 mb-1">Instagram URL</label>
                                        <input type="url" name="instagram_url"
                                            value="{{ old('instagram_url', $settings->instagram_url ?? '') }}"
                                            class="w-full px-3 py-2 bg-slate-50 border border-gray-200 rounded text-sm">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Copyright -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Bottom Bar: Copyright Text</label>
                            <input type="text" name="footer_text"
                                value="{{ old('footer_text', $settings->footer_text ?? '© 2025 CISA Interdisciplinary Journal. All rights reserved.') }}"
                                class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all">
                        </div>

                    </div>
                </div>


                <div class="flex justify-end pt-4">
                    <button type="submit"
                        class="px-8 py-3 bg-cisa-accent hover:bg-amber-600 text-white rounded-lg font-bold shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all flex items-center">
                        <i class="fas fa-save mr-2"></i>Save Header & Footer
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

                    <a href="{{ route('admin.website-settings.index') }}"
                        class="block w-full bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-3 rounded-lg font-bold transition-all text-center flex items-center justify-center">
                        <i class="fas fa-sliders-h mr-2"></i>General Settings
                    </a>
                </div>

                <div class="mt-8">
                    <h4 class="font-bold text-sm text-gray-500 mb-3 uppercase tracking-wider">Help & Tips</h4>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                            <span>All changes appear instantly on the live website.</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                            <span>Footer content is divided into 4 columns for better organization.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection