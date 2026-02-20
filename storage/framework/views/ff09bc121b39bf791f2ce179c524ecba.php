<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Admin Dashboard - CISA Interdisciplinary Journal'); ?></title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    },
                    colors: {
                        cisa: {
                            base: '#0f172a', /* Deep Slate Blue */
                            light: '#1e293b',
                            accent: '#f59e0b', /* Gold/Amber */
                            text: '#f8fafc',
                            muted: '#94a3b8',
                        }
                    },
                    boxShadow: {
                        'glass': '0 8px 32px 0 rgba(15, 23, 42, 0.1)',
                        'glow': '0 0 15px rgba(245, 158, 11, 0.3)',
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Quill.js -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Custom Scrollbar for Sidebar */
        .sidebar-scroll {
            scrollbar-width: thin;
            scrollbar-color: rgba(245, 158, 11, 0.3) rgba(15, 23, 42, 0.5);
        }

        .sidebar-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-scroll::-webkit-scrollbar-track {
            background: rgba(15, 23, 42, 0.5);
        }

        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: rgba(245, 158, 11, 0.3);
            border-radius: 10px;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(245, 158, 11, 0.8);
        }

        .nav-item-active {
            background: linear-gradient(90deg, rgba(245, 158, 11, 0.1) 0%, transparent 100%);
            border-left: 4px solid #f59e0b;
        }

        .nav-item-inactive {
            border-left: 4px solid transparent;
        }
    </style>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body class="bg-gray-100 min-h-screen font-sans text-gray-900 antialiased">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-72 bg-cisa-base text-white flex-shrink-0 flex flex-col h-screen shadow-2xl relative z-20"
            x-data="{ open: true }">

            <!-- Logo Section -->
            <div class="p-6 flex-shrink-0 border-b border-white/10 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-cisa-light to-cisa-base opacity-50"></div>
                <div class="flex items-center space-x-4 relative z-10">
                    <div
                        class="w-10 h-10 bg-cisa-accent rounded-lg flex items-center justify-center text-cisa-base shadow-glow">
                        <span class="font-serif font-bold text-xl">C</span>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold font-serif text-white tracking-wide">CISA</h1>
                        <p class="text-[10px] text-cisa-accent uppercase tracking-widest font-semibold">Admin Panel</p>
                    </div>
                </div>
            </div>

            <!-- Scrollable Navigation -->
            <nav class="flex-1 overflow-y-auto overflow-x-hidden sidebar-scroll py-6 space-y-1">

                <div class="px-6 mb-2">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Overview</p>
                </div>

                <a href="<?php echo e(route('admin.dashboard')); ?>"
                    class="flex items-center space-x-3 px-6 py-3.5 hover:bg-white/5 transition-all group <?php echo e(request()->routeIs('admin.dashboard') ? 'nav-item-active text-white' : 'nav-item-inactive text-slate-400 hover:text-white'); ?>">
                    <i
                        class="fas fa-grid-2 text-lg w-6 <?php echo e(request()->routeIs('admin.dashboard') ? 'text-cisa-accent' : 'text-slate-500 group-hover:text-cisa-accent transition-colors'); ?>"></i>
                    <span class="font-medium text-sm">Dashboard</span>
                </a>

                <div class="mt-8 px-6 mb-2">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Journal Management</p>
                </div>

                <a href="<?php echo e(route('admin.journals.index')); ?>"
                    class="flex items-center space-x-3 px-6 py-3.5 hover:bg-white/5 transition-all group <?php echo e(request()->routeIs('admin.journals.*') ? 'nav-item-active text-white' : 'nav-item-inactive text-slate-400 hover:text-white'); ?>">
                    <i
                        class="fas fa-book text-lg w-6 <?php echo e(request()->routeIs('admin.journals.*') ? 'text-cisa-accent' : 'text-slate-500 group-hover:text-cisa-accent transition-colors'); ?>"></i>
                    <span class="font-medium text-sm">Journals</span>
                </a>

                <a href="<?php echo e(route('admin.issues.index')); ?>"
                    class="flex items-center space-x-3 px-6 py-3.5 hover:bg-white/5 transition-all group <?php echo e(request()->routeIs('admin.issues.*') ? 'nav-item-active text-white' : 'nav-item-inactive text-slate-400 hover:text-white'); ?>">
                    <i
                        class="fas fa-layer-group text-lg w-6 <?php echo e(request()->routeIs('admin.issues.*') ? 'text-cisa-accent' : 'text-slate-500 group-hover:text-cisa-accent transition-colors'); ?>"></i>
                    <span class="font-medium text-sm">Issues & Volumes</span>
                </a>

                <a href="<?php echo e(route('admin.submissions.index')); ?>"
                    class="flex items-center space-x-3 px-6 py-3.5 hover:bg-white/5 transition-all group <?php echo e(request()->routeIs('admin.submissions.*') ? 'nav-item-active text-white' : 'nav-item-inactive text-slate-400 hover:text-white'); ?>">
                    <i
                        class="fas fa-file-contract text-lg w-6 <?php echo e(request()->routeIs('admin.submissions.*') ? 'text-cisa-accent' : 'text-slate-500 group-hover:text-cisa-accent transition-colors'); ?>"></i>
                    <span class="font-medium text-sm">Submissions</span>
                </a>

                <div class="mt-8 px-6 mb-2">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Content & Users</p>
                </div>

                <a href="<?php echo e(route('admin.journal-pages.index')); ?>"
                    class="flex items-center space-x-3 px-6 py-3.5 hover:bg-white/5 transition-all group <?php echo e(request()->routeIs('admin.journal-pages.*') ? 'nav-item-active text-white' : 'nav-item-inactive text-slate-400 hover:text-white'); ?>">
                    <i
                        class="fas fa-file-invoice text-lg w-6 <?php echo e(request()->routeIs('admin.journal-pages.*') ? 'text-cisa-accent' : 'text-slate-500 group-hover:text-cisa-accent transition-colors'); ?>"></i>
                    <span class="font-medium text-sm">Pages</span>
                </a>

                <a href="<?php echo e(route('admin.users.index')); ?>"
                    class="flex items-center space-x-3 px-6 py-3.5 hover:bg-white/5 transition-all group <?php echo e(request()->routeIs('admin.users.*') ? 'nav-item-active text-white' : 'nav-item-inactive text-slate-400 hover:text-white'); ?>">
                    <i
                        class="fas fa-users text-lg w-6 <?php echo e(request()->routeIs('admin.users.*') ? 'text-cisa-accent' : 'text-slate-500 group-hover:text-cisa-accent transition-colors'); ?>"></i>
                    <span class="font-medium text-sm">Users</span>
                </a>

                <a href="<?php echo e(route('admin.reviews.index')); ?>"
                    class="flex items-center space-x-3 px-6 py-3.5 hover:bg-white/5 transition-all group <?php echo e(request()->routeIs('admin.reviews.*') ? 'nav-item-active text-white' : 'nav-item-inactive text-slate-400 hover:text-white'); ?>">
                    <i
                        class="fas fa-star-half-alt text-lg w-6 <?php echo e(request()->routeIs('admin.reviews.*') ? 'text-cisa-accent' : 'text-slate-500 group-hover:text-cisa-accent transition-colors'); ?>"></i>
                    <span class="font-medium text-sm">Reviews</span>
                </a>

                <a href="<?php echo e(route('admin.announcements.index')); ?>"
                    class="flex items-center space-x-3 px-6 py-3.5 hover:bg-white/5 transition-all group <?php echo e(request()->routeIs('admin.announcements.*') ? 'nav-item-active text-white' : 'nav-item-inactive text-slate-400 hover:text-white'); ?>">
                    <i
                        class="fas fa-bullhorn text-lg w-6 <?php echo e(request()->routeIs('admin.announcements.*') ? 'text-cisa-accent' : 'text-slate-500 group-hover:text-cisa-accent transition-colors'); ?>"></i>
                    <span class="font-medium text-sm">Announcements</span>
                </a>

                <div class="mt-8 px-6 mb-2">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Configuration</p>
                </div>

                <a href="<?php echo e(route('admin.website-settings.header-footer')); ?>"
                    class="flex items-center space-x-3 px-6 py-3.5 hover:bg-white/5 transition-all group <?php echo e(request()->routeIs('admin.website-settings.header-footer') ? 'nav-item-active text-white' : 'nav-item-inactive text-slate-400 hover:text-white'); ?>">
                    <i
                        class="fas fa-columns text-lg w-6 <?php echo e(request()->routeIs('admin.website-settings.header-footer') ? 'text-cisa-accent' : 'text-slate-500 group-hover:text-cisa-accent transition-colors'); ?>"></i>
                    <span class="font-medium text-sm">Header & Footer</span>
                </a>

                <a href="<?php echo e(route('admin.website-settings.index')); ?>"
                    class="flex items-center space-x-3 px-6 py-3.5 hover:bg-white/5 transition-all group <?php echo e(request()->routeIs('admin.website-settings.index') ? 'nav-item-active text-white' : 'nav-item-inactive text-slate-400 hover:text-white'); ?>">
                    <i
                        class="fas fa-sliders-h text-lg w-6 <?php echo e(request()->routeIs('admin.website-settings.index') ? 'text-cisa-accent' : 'text-slate-500 group-hover:text-cisa-accent transition-colors'); ?>"></i>
                    <span class="font-medium text-sm">General Settings</span>
                </a>

                <a href="<?php echo e(route('admin.system-settings.index')); ?>"
                    class="flex items-center space-x-3 px-6 py-3.5 hover:bg-white/5 transition-all group <?php echo e(request()->routeIs('admin.system-settings.*') ? 'nav-item-active text-white' : 'nav-item-inactive text-slate-400 hover:text-white'); ?>">
                    <i
                        class="fas fa-envelope text-lg w-6 <?php echo e(request()->routeIs('admin.system-settings.*') ? 'text-cisa-accent' : 'text-slate-500 group-hover:text-cisa-accent transition-colors'); ?>"></i>
                    <span class="font-medium text-sm">SMTP Settings</span>
                </a>

                <a href="<?php echo e(route('admin.editorial-workflows.index')); ?>"
                    class="flex items-center space-x-3 px-6 py-3.5 hover:bg-white/5 transition-all group <?php echo e(request()->routeIs('admin.editorial-workflows.*') ? 'nav-item-active text-white' : 'nav-item-inactive text-slate-400 hover:text-white'); ?>">
                    <i
                        class="fas fa-project-diagram text-lg w-6 <?php echo e(request()->routeIs('admin.editorial-workflows.*') ? 'text-cisa-accent' : 'text-slate-500 group-hover:text-cisa-accent transition-colors'); ?>"></i>
                    <span class="font-medium text-sm">Workflows</span>
                </a>

                <a href="<?php echo e(route('admin.payment-methods.index')); ?>"
                    class="flex items-center space-x-3 px-6 py-3.5 hover:bg-white/5 transition-all group <?php echo e(request()->routeIs('admin.payment-methods.*') ? 'nav-item-active text-white' : 'nav-item-inactive text-slate-400 hover:text-white'); ?>">
                    <i
                        class="fas fa-wallet text-lg w-6 <?php echo e(request()->routeIs('admin.payment-methods.*') ? 'text-cisa-accent' : 'text-slate-500 group-hover:text-cisa-accent transition-colors'); ?>"></i>
                    <span class="font-medium text-sm">Payment Methods</span>
                </a>

                <!-- More links grouped under 'Advanced' if needed -->
                <div x-data="{ expanded: false }">
                    <button @click="expanded = !expanded"
                        class="w-full flex items-center justify-between px-6 py-3.5 text-slate-400 hover:text-white hover:bg-white/5 transition-all">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-toolbox text-lg w-6"></i>
                            <span class="font-medium text-sm">Tools & Advanced</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs transition-transform"
                            :class="{ 'rotate-180': expanded }"></i>
                    </button>

                    <div x-show="expanded" x-collapse class="bg-black/20">
                        <a href="<?php echo e(route('admin.page-builder.pages.index')); ?>"
                            class="flex items-center space-x-3 pl-14 pr-6 py-3 text-sm text-slate-400 hover:text-cisa-accent transition-colors">
                            <span>Page Builder</span>
                        </a>
                        <a href="<?php echo e(route('admin.email-templates.index')); ?>"
                            class="flex items-center space-x-3 pl-14 pr-6 py-3 text-sm text-slate-400 hover:text-cisa-accent transition-colors">
                            <span>Email Templates</span>
                        </a>
                        <a href="<?php echo e(route('admin.payments.index')); ?>"
                            class="flex items-center space-x-3 pl-14 pr-6 py-3 text-sm text-slate-400 hover:text-cisa-accent transition-colors">
                            <span>Payments</span>
                        </a>
                    </div>
                </div>

            </nav>

            <!-- Bottom Actions -->
            <div class="p-4 border-t border-white/10 bg-cisa-light/50 backdrop-blur-sm">
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit"
                        class="w-full flex items-center justify-center space-x-2 px-4 py-2 bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white rounded-lg transition-all duration-300 font-medium text-sm group">
                        <i class="fas fa-sign-out-alt group-hover:rotate-180 transition-transform duration-300"></i>
                        <span>Sign Out</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden bg-slate-50">
            <!-- Top Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 z-10">
                <div class="px-8 py-4 flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-cisa-base font-serif">
                            <?php echo $__env->yieldContent('page-title', 'Admin Dashboard'); ?>
                        </h2>
                        <p class="text-sm text-cisa-muted mt-1">
                            <?php echo $__env->yieldContent('page-subtitle', 'Manage your journal publishing platform'); ?></p>
                    </div>
                    <div class="flex items-center space-x-6">
                        <a href="<?php echo e(route('journals.index')); ?>" target="_blank"
                            class="flex items-center space-x-2 text-cisa-muted hover:text-cisa-accent transition-colors px-3 py-1.5 rounded-lg hover:bg-orange-50"
                            title="View Website">
                            <i class="fas fa-external-link-alt text-sm"></i>
                            <span class="text-sm font-medium">Live Site</span>
                        </a>

                        <div class="h-8 w-px bg-gray-200"></div>

                        <div class="flex items-center space-x-3 pl-2">
                            <div class="text-right hidden md:block">
                                <p class="text-sm font-bold text-cisa-base"><?php echo e(auth()->user()->full_name); ?></p>
                                <p class="text-[10px] text-cisa-accent uppercase tracking-wider font-bold">Administrator
                                </p>
                            </div>
                            <div
                                class="w-10 h-10 bg-cisa-base text-cisa-accent rounded-full flex items-center justify-center border-2 border-cisa-accent shadow-sm">
                                <span class="font-serif font-bold"><?php echo e(substr(auth()->user()->first_name, 0, 1)); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-8">
                <?php echo $__env->yieldContent('content'); ?>
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 mt-auto">
                <div class="px-8 py-4 flex justify-between items-center">
                    <div>
                        <p class="text-gray-400 text-xs">&copy; <?php echo e(date('Y')); ?> CISA Interdisciplinary Journal. All
                            rights reserved.</p>
                    </div>
                    <p class="text-gray-300 text-xs">v2.4.0 (Premium Sapphire)</p>
                </div>
            </footer>
        </div>
    </div>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html><?php /**PATH /home/u857061584/domains/cisajournal.org/public_html/resources/views/layouts/admin.blade.php ENDPATH**/ ?>