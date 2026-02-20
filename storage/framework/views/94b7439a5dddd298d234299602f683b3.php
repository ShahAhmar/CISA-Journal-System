<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'CISA Interdisciplinary Journal (CIJ) - A Platform for Interdisciplinary Research Excellence'); ?></title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#faf5ff',
                            100: '#f3e8ff',
                            200: '#e9d5ff',
                            300: '#d8b4fe',
                            400: '#c084fc',
                            500: '#a855f7',
                            600: '#9333ea',
                            700: '#7e22ce',
                            800: '#6b21a8',
                            900: '#581c87',
                        },
                        accent: {
                            50: '#faf5ff',
                            100: '#f3e8ff',
                            200: '#e9d5ff',
                            300: '#d8b4ff',
                            400: '#c084fc',
                            500: '#a855f7',
                            600: '#9333ea',
                            700: '#7e22ce',
                            800: '#6b21a8',
                            900: '#581c87',
                        }
                    },
                    fontFamily: {
                        'sans': ['Inter', 'sans-serif'],
                        'display': ['Playfair Display', 'serif'],
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in',
                        'slide-up': 'slideUp 0.5s ease-out',
                        'slide-down': 'slideDown 0.3s ease-out',
                        'bounce-slow': 'bounce 2s infinite',
                        'pulse-slow': 'pulse 3s infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        slideDown: {
                            '0%': { transform: 'translateY(-10px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                    },
                },
            },
        }
    </script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        /* Smooth Scrolling */
        html {
            scroll-behavior: smooth;
        }
        
        /* Ultra Professional Button Styles */
        .btn {
            @apply px-6 py-3 rounded-xl font-semibold text-sm transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98] shadow-md hover:shadow-xl;
            position: relative;
            overflow: hidden;
            letter-spacing: 0.025em;
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.4s ease, height 0.4s ease;
        }
        
        .btn:hover::before {
            width: 300px;
            height: 300px;
        }
        
        .btn-primary {
            @apply bg-gradient-to-r from-purple-600 to-purple-700 text-white hover:from-purple-700 hover:to-purple-800;
            box-shadow: 0 4px 14px 0 rgba(147, 51, 234, 0.3);
        }
        
        .btn-primary:hover {
            box-shadow: 0 6px 20px 0 rgba(147, 51, 234, 0.4);
        }
        
        .btn-secondary {
            @apply bg-white border-2 border-gray-200 text-gray-700 hover:border-purple-300 hover:text-purple-700 hover:bg-purple-50;
        }
        
        .btn-danger {
            @apply bg-gradient-to-r from-red-600 to-red-700 text-white hover:from-red-700 hover:to-red-800;
            box-shadow: 0 4px 14px 0 rgba(220, 38, 38, 0.3);
        }
        
        .btn-outline {
            @apply bg-transparent border-2 border-purple-600 text-purple-600 hover:bg-purple-600 hover:text-white;
        }
        
        /* Ultra Professional Card Styles */
        .card {
            @apply bg-white rounded-2xl shadow-lg p-6 transition-all duration-200 hover:shadow-2xl hover:-translate-y-1;
            border: 1px solid rgba(0, 0, 0, 0.06);
            backdrop-filter: blur(10px);
        }
        
        .card-hover {
            @apply hover:bg-gradient-to-br hover:from-purple-50 hover:to-purple-100/50;
        }
        
        .card:hover {
            border-color: rgba(147, 51, 234, 0.2);
        }
        
        /* Ultra Professional Form Input Styles */
        .form-input {
            @apply w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all duration-200;
            background: white;
            font-size: 14px;
        }
        
        .form-input:focus {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(147, 51, 234, 0.15);
            border-color: #9333ea;
        }
        
        .form-input:hover {
            border-color: #d8b4fe;
        }
        
        .form-label {
            @apply block text-sm font-semibold text-gray-800 mb-2;
            letter-spacing: 0.01em;
        }
        
        /* Badge Styles */
        .badge {
            @apply inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold transition-all duration-300;
        }
        
        .badge-success {
            @apply bg-gradient-to-r from-green-100 to-green-200 text-green-800 border border-green-300;
        }
        
        .badge-warning {
            @apply bg-gradient-to-r from-yellow-100 to-yellow-200 text-yellow-800 border border-yellow-300;
        }
        
        .badge-danger {
            @apply bg-gradient-to-r from-red-100 to-red-200 text-red-800 border border-red-300;
        }
        
        .badge-info {
            @apply bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 border border-blue-300;
        }
        
        /* Ultra Professional Navigation Styles */
        .nav-link {
            @apply relative px-4 py-2 text-gray-700 font-semibold transition-all duration-200;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: linear-gradient(to right, #9333ea, #7e22ce);
            transition: all 0.3s ease;
            transform: translateX(-50%);
            border-radius: 2px;
        }
        
        .nav-link:hover::after,
        .nav-link.active::after {
            width: 80%;
        }
        
        .nav-link:hover {
            @apply text-purple-700;
        }
        
        /* Professional Header Effects */
        nav {
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        
        nav.scrolled {
            @apply shadow-xl;
            background: rgba(255, 255, 255, 0.98);
        }
        
        /* Alert Styles */
        .alert {
            @apply rounded-lg p-4 mb-4 border-l-4 animate-slide-down;
        }
        
        .alert-success {
            @apply bg-green-50 border-green-500 text-green-800;
        }
        
        .alert-error {
            @apply bg-red-50 border-red-500 text-red-800;
        }
        
        /* Ultra Professional Table Styles */
        .table-wrapper {
            @apply overflow-x-auto rounded-2xl shadow-lg border border-gray-100;
        }
        
        table {
            @apply min-w-full divide-y divide-gray-100;
        }
        
        thead {
            @apply bg-gradient-to-r from-purple-600 to-purple-700;
        }
        
        th {
            @apply px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider;
            letter-spacing: 0.05em;
        }
        
        tbody {
            @apply bg-white divide-y divide-gray-100;
        }
        
        td {
            @apply px-6 py-4 whitespace-nowrap text-sm text-gray-700;
        }
        
        tr:hover {
            @apply bg-purple-50 transition-colors duration-150;
        }
        
        tr {
            @apply border-b border-gray-50;
        }
        
        /* Loading Animation */
        .loading {
            @apply inline-block w-4 h-4 border-2 border-primary-600 border-t-transparent rounded-full animate-spin;
        }
        
        /* Gradient Background */
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .gradient-bg-primary {
            background: linear-gradient(135deg, #0284c7 0%, #0ea5e9 100%);
        }
        
        /* Ultra Professional Text Gradient */
        .text-gradient {
            background: linear-gradient(135deg, #9333ea 0%, #7e22ce 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Professional Section Dividers */
        .section-divider {
            @apply border-t border-gray-100 my-12;
        }
        
        /* Professional Badge Enhancements */
        .badge {
            @apply inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold transition-all duration-200;
            letter-spacing: 0.025em;
        }
        
        .badge-purple {
            @apply bg-purple-100 text-purple-800 border border-purple-200;
        }
        
        /* Professional Shadows */
        .shadow-professional {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .shadow-professional-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        /* Professional Hover Effects */
        .hover-lift {
            @apply transition-transform duration-200;
        }
        
        .hover-lift:hover {
            transform: translateY(-2px);
        }
        
        /* Professional Border Radius */
        .rounded-professional {
            border-radius: 0.75rem;
        }
        
        .rounded-professional-lg {
            border-radius: 1rem;
        }
        
        /* Ultra Professional Smooth Transitions */
        * {
            transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 200ms;
        }
        
        /* Professional Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #c084fc;
            border-radius: 5px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #9333ea;
        }
        
        /* Professional Selection */
        ::selection {
            background: rgba(147, 51, 234, 0.2);
            color: #581c87;
        }
        
        /* Professional Focus Styles */
        *:focus-visible {
            outline: 2px solid #9333ea;
            outline-offset: 2px;
        }
        
        /* Professional Typography */
        h1, h2, h3, h4, h5, h6 {
            letter-spacing: -0.02em;
            font-weight: 700;
        }
        
        /* Professional Link Styles */
        a {
            text-decoration: none;
        }
        
        a:hover {
            text-decoration: none;
        }
        
        /* Professional Image Loading */
        img {
            image-rendering: -webkit-optimize-contrast;
            image-rendering: crisp-edges;
        }
    </style>
</head>
<body class="bg-white min-h-screen antialiased">
    <!-- Ultra Professional Navigation -->
    <nav class="bg-white/95 backdrop-blur-md shadow-lg border-b border-gray-100 sticky top-0 z-50 transition-all duration-300" x-data="{ mobileOpen: false, scrolled: false }" @scroll.window="scrolled = window.scrollY > 20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center min-h-[70px] sm:min-h-[80px]">
                <div class="flex items-center space-x-4 sm:space-x-6 md:space-x-8 flex-1 min-w-0">
                    <div class="flex-shrink-0">
                        <a href="<?php echo e(route('journals.index')); ?>" class="flex items-center no-underline hover:no-underline group">
                            <?php
                                $websiteSettings = \App\Models\WebsiteSetting::getSettings();
                                $logoUrl = null;
                                
                                if ($websiteSettings && !empty($websiteSettings->logo)) {
                                    $logoPath = trim($websiteSettings->logo);
                                    
                                    // Handle different path formats
                                    if (strpos($logoPath, 'http://') === 0 || strpos($logoPath, 'https://') === 0) {
                                        // Full URL - use as is
                                        $logoUrl = $logoPath;
                                    } elseif (strpos($logoPath, 'uploads/') === 0) {
                                        // Path starts with uploads/ - use asset() but fix /public issue
                                        $assetUrl = asset($logoPath);
                                        // Remove /public from URL if it exists (some server configs add it)
                                        $logoUrl = str_replace('/public/uploads/', '/uploads/', $assetUrl);
                                        $logoUrl = str_replace('/public/public/', '/public/', $logoUrl);
                                    } elseif (strpos($logoPath, 'storage/') === 0) {
                                        $assetUrl = asset($logoPath);
                                        $logoUrl = str_replace('/public/storage/', '/storage/', $assetUrl);
                                    } else {
                                        // Default: assume it's in uploads/
                                        $assetUrl = asset('uploads/' . ltrim($logoPath, '/'));
                                        $logoUrl = str_replace('/public/uploads/', '/uploads/', $assetUrl);
                                    }
                                }
                            ?>
                            
                            <?php if($logoUrl): ?>
                                <img src="<?php echo e($logoUrl); ?>" 
                                     alt="CISA Interdisciplinary Journal Logo" 
                                     class="h-14 w-auto sm:h-16 md:h-20 lg:h-24 object-contain transition-transform duration-300 group-hover:scale-105 max-w-[200px] sm:max-w-[250px] md:max-w-[300px]"
                                     style="display: block;"
                                     onerror="console.error('Logo failed to load:', this.src); this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="w-14 h-14 sm:w-16 sm:h-16 md:h-20 md:w-20 lg:h-24 lg:w-24 bg-gradient-to-br from-purple-600 to-purple-800 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg" style="display:none;">
                                    <i class="fas fa-book-open text-white text-xl sm:text-2xl md:text-3xl"></i>
                                </div>
                            <?php else: ?>
                                <div class="w-14 h-14 sm:w-16 sm:h-16 md:h-20 md:w-20 lg:h-24 lg:w-24 bg-gradient-to-br from-purple-600 to-purple-800 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg transition-transform duration-300 group-hover:scale-105">
                                    <i class="fas fa-book-open text-white text-xl sm:text-2xl md:text-3xl"></i>
                                </div>
                            <?php endif; ?>
                        </a>
                    </div>
                    <div class="hidden lg:flex items-center space-x-1">
                        <a href="<?php echo e(route('journals.index')); ?>" class="px-4 py-2 text-sm font-semibold text-purple-700 rounded-lg hover:bg-purple-50 transition-all duration-200 relative">
                            <span class="relative z-10"><?php echo e(__('common.home')); ?></span>
                            <span class="absolute bottom-0 left-0 right-0 h-0.5 bg-purple-600 rounded-full"></span>
                        </a>
                        <a href="<?php echo e(route('publish.index')); ?>" class="px-4 py-2 text-sm font-semibold text-gray-700 rounded-lg hover:bg-purple-50 hover:text-purple-700 transition-all duration-200">
                            <?php echo e(__('common.publish_with_us')); ?>

                        </a>
                        <a href="<?php echo e(route('journals.index')); ?>#journals" class="px-4 py-2 text-sm font-semibold text-gray-700 rounded-lg hover:bg-purple-50 hover:text-purple-700 transition-all duration-200">
                            <?php echo e(__('common.journals')); ?>

                        </a>
                        <a href="<?php echo e(route('journals.index')); ?>#announcements" class="px-4 py-2 text-sm font-semibold text-gray-700 rounded-lg hover:bg-purple-50 hover:text-purple-700 transition-all duration-200">
                            Announcements
                        </a>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <!-- Language Switcher -->
                    <div class="hidden lg:block relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-1.5 px-3 py-2 text-sm font-medium text-gray-700 hover:text-purple-700 hover:bg-purple-50 rounded-lg transition-all duration-200 border border-gray-200 hover:border-purple-200">
                            <i class="fas fa-globe text-xs"></i>
                            <span class="uppercase text-xs font-semibold"><?php echo e(app()->getLocale()); ?></span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-44 bg-white rounded-xl shadow-2xl border border-gray-100 z-50 overflow-hidden">
                            <a href="<?php echo e(route('language.switch', ['locale' => 'en'])); ?>" class="flex items-center px-4 py-2.5 hover:bg-purple-50 text-gray-700 hover:text-purple-700 transition-colors border-b border-gray-50 last:border-0">
                                <span class="mr-3 text-lg">🇬🇧</span> <span class="font-medium">English</span>
                            </a>
                            <a href="<?php echo e(route('language.switch', ['locale' => 'fr'])); ?>" class="flex items-center px-4 py-2.5 hover:bg-purple-50 text-gray-700 hover:text-purple-700 transition-colors border-b border-gray-50 last:border-0">
                                <span class="mr-3 text-lg">🇫🇷</span> <span class="font-medium">Français</span>
                            </a>
                            <a href="<?php echo e(route('language.switch', ['locale' => 'es'])); ?>" class="flex items-center px-4 py-2.5 hover:bg-purple-50 text-gray-700 hover:text-purple-700 transition-colors border-b border-gray-50 last:border-0">
                                <span class="mr-3 text-lg">🇪🇸</span> <span class="font-medium">Español</span>
                            </a>
                            <a href="<?php echo e(route('language.switch', ['locale' => 'pt'])); ?>" class="flex items-center px-4 py-2.5 hover:bg-purple-50 text-gray-700 hover:text-purple-700 transition-colors border-b border-gray-50 last:border-0">
                                <span class="mr-3 text-lg">🇵🇹</span> <span class="font-medium">Português</span>
                            </a>
                            <a href="<?php echo e(route('language.switch', ['locale' => 'sw'])); ?>" class="flex items-center px-4 py-2.5 hover:bg-purple-50 text-gray-700 hover:text-purple-700 transition-colors">
                                <span class="mr-3 text-lg">🇹🇿</span> <span class="font-medium">Kiswahili</span>
                            </a>
                        </div>
                    </div>
                    <?php if(auth()->guard()->check()): ?>
                        <div class="hidden lg:flex items-center space-x-2">
                            <?php if(auth()->user()->role === 'admin'): ?>
                                <a href="<?php echo e(route('admin.dashboard')); ?>" class="px-4 py-2 text-sm font-semibold text-gray-700 hover:text-purple-700 hover:bg-purple-50 rounded-lg transition-all duration-200">
                                    Dashboard
                                </a>
                            <?php elseif(auth()->user()->role === 'reviewer'): ?>
                                <a href="<?php echo e(route('reviewer.dashboard')); ?>" class="px-4 py-2 text-sm font-semibold text-gray-700 hover:text-purple-700 hover:bg-purple-50 rounded-lg transition-all duration-200">
                                    Dashboard
                                </a>
                            <?php elseif(auth()->user()->role === 'copyeditor'): ?>
                                <a href="<?php echo e(route('copyeditor.dashboard')); ?>" class="px-4 py-2 text-sm font-semibold text-gray-700 hover:text-purple-700 hover:bg-purple-50 rounded-lg transition-all duration-200">
                                    Dashboard
                                </a>
                            <?php elseif(auth()->user()->role === 'proofreader'): ?>
                                <a href="<?php echo e(route('proofreader.dashboard')); ?>" class="px-4 py-2 text-sm font-semibold text-gray-700 hover:text-purple-700 hover:bg-purple-50 rounded-lg transition-all duration-200">
                                    Dashboard
                                </a>
                            <?php elseif(auth()->user()->journals()->wherePivotIn('role', ['journal_manager', 'editor', 'section_editor'])->wherePivot('is_active', true)->exists()): ?>
                                <a href="<?php echo e(route('dashboard')); ?>" class="px-4 py-2 text-sm font-semibold text-gray-700 hover:text-purple-700 hover:bg-purple-50 rounded-lg transition-all duration-200">
                                    Dashboard
                                </a>
                            <?php else: ?>
                            <a href="<?php echo e(route('dashboard')); ?>" class="px-4 py-2 text-sm font-semibold text-gray-700 hover:text-purple-700 hover:bg-purple-50 rounded-lg transition-all duration-200">
                                Dashboard
                            </a>
                            <?php endif; ?>
                            <a href="<?php echo e(route('profile.show')); ?>" class="px-4 py-2 text-sm font-semibold text-gray-700 hover:text-purple-700 hover:bg-purple-50 rounded-lg transition-all duration-200">
                                Profile
                            </a>
                            <?php if(auth()->user()->role === 'admin'): ?>
                                <a href="<?php echo e(route('admin.dashboard')); ?>" class="px-4 py-2 text-sm font-semibold text-gray-700 hover:text-purple-700 hover:bg-purple-50 rounded-lg transition-all duration-200">
                                    Admin
                                </a>
                            <?php endif; ?>
                            <form method="POST" action="<?php echo e(route('logout')); ?>" class="inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="px-4 py-2 text-sm font-semibold text-gray-700 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200">
                                    Logout
                                </button>
                            </form>
                        </div>
                    <?php else: ?>
                        <div class="hidden lg:flex items-center space-x-3">
                            <a href="<?php echo e(route('login')); ?>" class="px-4 py-2 text-sm font-semibold text-gray-700 hover:text-purple-700 hover:bg-purple-50 rounded-lg transition-all duration-200">
                                Sign In
                            </a>
                            <a href="<?php echo e(route('register')); ?>" class="bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white px-5 py-2 rounded-lg font-semibold text-sm shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105">
                                Get Started
                            </a>
                        </div>
                    <?php endif; ?>
                    <div class="lg:hidden">
                        <button class="p-2 text-gray-700 hover:text-purple-700 hover:bg-purple-50 rounded-lg transition-all duration-200" @click="mobileOpen = !mobileOpen" aria-label="Toggle menu">
                            <i class="fas text-xl" :class="mobileOpen ? 'fa-times' : 'fa-bars'"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ultra Professional Mobile Menu -->
        <div class="lg:hidden bg-white/98 backdrop-blur-md shadow-xl border-t border-gray-100" x-show="mobileOpen" x-transition @click.away="mobileOpen = false">
            <div class="px-4 py-4 space-y-2">
                <!-- Mobile Language Switcher -->
                <div class="border-b border-gray-100 pb-4 mb-4">
                    <label class="block text-xs font-bold text-gray-600 mb-3 uppercase tracking-wider">Language</label>
                    <div class="grid grid-cols-5 gap-2">
                        <a href="<?php echo e(route('language.switch', ['locale' => 'en'])); ?>" class="px-2 py-2 text-xs rounded-lg text-center font-semibold transition-all duration-200 <?php echo e(app()->getLocale() === 'en' ? 'bg-gradient-to-r from-purple-600 to-purple-700 text-white shadow-md' : 'bg-gray-50 text-gray-700 hover:bg-purple-50 hover:text-purple-700 border border-gray-200'); ?>">🇬🇧 EN</a>
                        <a href="<?php echo e(route('language.switch', ['locale' => 'fr'])); ?>" class="px-2 py-2 text-xs rounded-lg text-center font-semibold transition-all duration-200 <?php echo e(app()->getLocale() === 'fr' ? 'bg-gradient-to-r from-purple-600 to-purple-700 text-white shadow-md' : 'bg-gray-50 text-gray-700 hover:bg-purple-50 hover:text-purple-700 border border-gray-200'); ?>">🇫🇷 FR</a>
                        <a href="<?php echo e(route('language.switch', ['locale' => 'es'])); ?>" class="px-2 py-2 text-xs rounded-lg text-center font-semibold transition-all duration-200 <?php echo e(app()->getLocale() === 'es' ? 'bg-gradient-to-r from-purple-600 to-purple-700 text-white shadow-md' : 'bg-gray-50 text-gray-700 hover:bg-purple-50 hover:text-purple-700 border border-gray-200'); ?>">🇪🇸 ES</a>
                        <a href="<?php echo e(route('language.switch', ['locale' => 'pt'])); ?>" class="px-2 py-2 text-xs rounded-lg text-center font-semibold transition-all duration-200 <?php echo e(app()->getLocale() === 'pt' ? 'bg-gradient-to-r from-purple-600 to-purple-700 text-white shadow-md' : 'bg-gray-50 text-gray-700 hover:bg-purple-50 hover:text-purple-700 border border-gray-200'); ?>">🇵🇹 PT</a>
                        <a href="<?php echo e(route('language.switch', ['locale' => 'sw'])); ?>" class="px-2 py-2 text-xs rounded-lg text-center font-semibold transition-all duration-200 <?php echo e(app()->getLocale() === 'sw' ? 'bg-gradient-to-r from-purple-600 to-purple-700 text-white shadow-md' : 'bg-gray-50 text-gray-700 hover:bg-purple-50 hover:text-purple-700 border border-gray-200'); ?>">🇹🇿 SW</a>
                    </div>
                </div>
                
                <!-- Mobile Navigation Links -->
                <a href="<?php echo e(route('journals.index')); ?>" class="block px-4 py-3 text-sm font-semibold text-gray-700 hover:text-purple-700 hover:bg-purple-50 rounded-lg transition-all duration-200">
                    <i class="fas fa-home mr-2"></i>Home
                </a>
                <a href="<?php echo e(route('publish.index')); ?>" class="block px-4 py-3 text-sm font-semibold text-gray-700 hover:text-purple-700 hover:bg-purple-50 rounded-lg transition-all duration-200">
                    <i class="fas fa-paper-plane mr-2"></i>Publish With Us
                </a>
                <a href="<?php echo e(route('journals.index')); ?>#journals" class="block px-4 py-3 text-sm font-semibold text-gray-700 hover:text-purple-700 hover:bg-purple-50 rounded-lg transition-all duration-200">
                    <i class="fas fa-book mr-2"></i>Journals
                </a>
                <?php if(auth()->guard()->check()): ?>
                    <div class="border-t border-gray-100 pt-4 mt-4">
                        <?php if(auth()->user()->role === 'admin'): ?>
                            <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center px-4 py-3 text-sm font-semibold text-gray-700 hover:text-purple-700 hover:bg-purple-50 rounded-lg transition-all duration-200 mb-2">
                                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                            </a>
                        <?php elseif(auth()->user()->role === 'reviewer'): ?>
                            <a href="<?php echo e(route('reviewer.dashboard')); ?>" class="flex items-center px-4 py-3 text-sm font-semibold text-gray-700 hover:text-purple-700 hover:bg-purple-50 rounded-lg transition-all duration-200 mb-2">
                                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                            </a>
                        <?php elseif(auth()->user()->role === 'copyeditor'): ?>
                            <a href="<?php echo e(route('copyeditor.dashboard')); ?>" class="flex items-center px-4 py-3 text-sm font-semibold text-gray-700 hover:text-purple-700 hover:bg-purple-50 rounded-lg transition-all duration-200 mb-2">
                                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                            </a>
                        <?php elseif(auth()->user()->role === 'proofreader'): ?>
                            <a href="<?php echo e(route('proofreader.dashboard')); ?>" class="flex items-center px-4 py-3 text-sm font-semibold text-gray-700 hover:text-purple-700 hover:bg-purple-50 rounded-lg transition-all duration-200 mb-2">
                                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                            </a>
                        <?php elseif(auth()->user()->journals()->wherePivotIn('role', ['journal_manager', 'editor', 'section_editor'])->wherePivot('is_active', true)->exists()): ?>
                            <a href="<?php echo e(route('dashboard')); ?>" class="flex items-center px-4 py-3 text-sm font-semibold text-gray-700 hover:text-purple-700 hover:bg-purple-50 rounded-lg transition-all duration-200 mb-2">
                                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                            </a>
                        <?php else: ?>
                        <a href="<?php echo e(route('dashboard')); ?>" class="flex items-center px-4 py-3 text-sm font-semibold text-gray-700 hover:text-purple-700 hover:bg-purple-50 rounded-lg transition-all duration-200 mb-2">
                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                        </a>
                        <?php endif; ?>
                        <a href="<?php echo e(route('profile.show')); ?>" class="flex items-center px-4 py-3 text-sm font-semibold text-gray-700 hover:text-purple-700 hover:bg-purple-50 rounded-lg transition-all duration-200 mb-2">
                            <i class="fas fa-user mr-2"></i>Profile
                        </a>
                        <?php if(auth()->user()->role === 'admin'): ?>
                            <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center px-4 py-3 text-sm font-semibold text-gray-700 hover:text-purple-700 hover:bg-purple-50 rounded-lg transition-all duration-200 mb-2">
                                <i class="fas fa-cog mr-2"></i>Admin
                            </a>
                        <?php endif; ?>
                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="w-full flex items-center px-4 py-3 text-sm font-semibold text-left text-gray-700 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </button>
                        </form>
                    </div>
                <?php else: ?>
                    <div class="border-t border-gray-100 pt-4 mt-4 space-y-2">
                        <a href="<?php echo e(route('login')); ?>" class="block px-4 py-3 text-sm font-semibold text-gray-700 hover:text-purple-700 hover:bg-purple-50 rounded-lg transition-all duration-200 text-center">
                            Sign In
                        </a>
                        <a href="<?php echo e(route('register')); ?>" class="block px-4 py-3 text-sm font-semibold bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-lg transition-all duration-200 text-center shadow-md">
                            Get Started
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
        <?php if(session('success')): ?>
            <div class="alert alert-success animate-slide-down">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-3 text-xl"></i>
                    <span class="font-semibold"><?php echo e(session('success')); ?></span>
                </div>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-error animate-slide-down">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-3 text-xl"></i>
                    <span class="font-semibold"><?php echo e(session('error')); ?></span>
                </div>
            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="alert alert-error animate-slide-down">
                <div class="flex items-start">
                    <i class="fas fa-exclamation-triangle mr-3 text-xl mt-1"></i>
                    <div>
                        <p class="font-semibold mb-2">Please fix the following errors:</p>
                        <ul class="list-disc list-inside space-y-1">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Main Content -->
    <main class="animate-fade-in">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Ultra Professional WhatsApp Floating Button -->
    <a href="https://wa.me/27734030207" target="_blank" class="fixed bottom-6 right-6 z-50 bg-gradient-to-br from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-full p-4 shadow-2xl transition-all duration-300 hover:scale-110 group" aria-label="Contact us on WhatsApp">
        <i class="fab fa-whatsapp text-3xl group-hover:scale-110 transition-transform duration-300"></i>
        <span class="absolute -top-2 -right-2 w-4 h-4 bg-red-500 rounded-full border-2 border-white animate-pulse"></span>
    </a>

    <!-- Ultra Professional Footer -->
    <footer class="bg-gradient-to-br from-purple-900 via-purple-800 to-purple-900 text-white mt-20 border-t-4 border-purple-700">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <!-- Information for -->
                <div>
                    <h4 class="text-lg font-bold mb-4">Information for</h4>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="#" class="hover:text-white transition-colors">Authors</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">R&D professionals</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Editors</a></li>
                    </ul>
                </div>
                
                <!-- Open access -->
                <div>
                    <h4 class="text-lg font-bold mb-4">Open access</h4>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="#" class="hover:text-white transition-colors">Overview</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Open journals</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Open Select</a></li>
                    </ul>
                </div>
                
                <!-- Help and information -->
                <div>
                    <h4 class="text-lg font-bold mb-4">Help and information</h4>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="#" class="hover:text-white transition-colors">Help and contact</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Newsroom</a></li>
                        <li><a href="<?php echo e(route('journals.index')); ?>" class="hover:text-white transition-colors">All journals</a></li>
                    </ul>
                </div>
                
                <!-- Connect with us -->
                <div>
                    <h4 class="text-lg font-bold mb-4">Connect with us</h4>
                    <div class="flex space-x-4">
                        <a href="https://wa.me/27734030207" target="_blank" class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center hover:bg-green-600 transition-colors" title="WhatsApp">
                            <i class="fab fa-whatsapp text-white"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center hover:bg-purple-700 transition-colors">
                            <i class="fab fa-twitter text-white"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center hover:bg-purple-700 transition-colors">
                            <i class="fab fa-linkedin-in text-white"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center hover:bg-purple-700 transition-colors">
                            <i class="fab fa-facebook-f text-white"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center hover:bg-purple-700 transition-colors">
                            <i class="fab fa-instagram text-white"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-purple-700/50 pt-8 pb-6 text-center">
                <div class="flex items-center justify-center mb-4">
                    <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center mr-3">
                        <i class="fas fa-book-open text-xl"></i>
                    </div>
                    <div class="text-left">
                        <p class="text-white font-bold text-sm">CISA Interdisciplinary Journal</p>
                        <p class="text-purple-200 text-xs">Interdisciplinary Research Excellence</p>
                    </div>
                </div>
                <p class="text-purple-200 text-xs mb-2">&copy; <?php echo e(date('Y')); ?> CISA Interdisciplinary Journal. All rights reserved.</p>
                <p class="text-purple-300 text-xs">A Platform for Interdisciplinary Research Excellence</p>
            </div>
        </div>
    </footer>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\cisa\resources\views/layouts/app.blade.php ENDPATH**/ ?>