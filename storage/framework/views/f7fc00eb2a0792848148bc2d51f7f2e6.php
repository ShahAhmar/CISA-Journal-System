<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Admin Dashboard - EMANP'); ?></title>
    
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
                        'navy': '#0F1B4C',
                        'bright-blue': '#0056FF',
                        'light-blue': '#1D72B8',
                        'off-white': '#F7F9FC',
                    },
                    fontFamily: {
                        'sans': ['Inter', 'sans-serif'],
                        'display': ['Playfair Display', 'serif'],
                    },
                },
            },
        }
    </script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Quill.js Rich Text Editor (Free, No API Key Required) -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        .ql-container {
            font-family: 'Inter', sans-serif;
            font-size: 14px;
        }
        .ql-editor {
            min-height: 300px;
        }
        
        /* Custom Scrollbar for Sidebar */
        .sidebar-scroll {
            scrollbar-width: thin;
            scrollbar-color: rgba(0, 86, 255, 0.5) rgba(15, 27, 76, 0.3);
        }
        
        .sidebar-scroll::-webkit-scrollbar {
            width: 8px;
        }
        
        .sidebar-scroll::-webkit-scrollbar-track {
            background: rgba(15, 27, 76, 0.3);
            border-radius: 10px;
        }
        
        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: rgba(0, 86, 255, 0.5);
            border-radius: 10px;
            transition: background 0.3s ease;
        }
        
        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 86, 255, 0.8);
        }
        
        /* Smooth Scrolling */
        .sidebar-scroll {
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
        }
    </style>
    
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="bg-[#F7F9FC]">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-[#0F1B4C] text-white flex-shrink-0 flex flex-col h-screen" x-data="{ open: true }">
            <!-- Logo Section -->
            <div class="p-6 flex-shrink-0 border-b border-blue-800">
                <div class="flex items-center space-x-3">
                    <?php
                        $websiteSettings = \App\Models\WebsiteSetting::getSettings();
                        $showLogo = false;
                        $logoUrl = '';
                        
                        if ($websiteSettings && $websiteSettings->logo) {
                            $logoPath = $websiteSettings->logo;
                            
                            // Normalize path - ensure it starts with 'uploads/'
                            if (strpos($logoPath, 'uploads/') !== 0 && strpos($logoPath, 'storage/') !== 0) {
                                $logoPath = 'uploads/' . $logoPath;
                            }
                            
                            // Normalize path - ensure it starts with 'uploads/'
                            if (strpos($logoPath, 'uploads/') !== 0 && strpos($logoPath, 'storage/') !== 0) {
                                $logoPath = 'uploads/' . $logoPath;
                            }
                            
                            // Use asset() helper for shared hosting compatibility
                            // Path should be relative to public directory
                            $logoUrl = asset($logoPath);
                            $showLogo = true;
                        }
                    ?>
                    
                    <?php if($showLogo): ?>
                        <img src="<?php echo e($logoUrl); ?>" alt="EMANP Logo" class="h-12 w-auto object-contain max-w-[120px] transition-all duration-300" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="w-12 h-12 bg-gradient-to-br from-[#0056FF] to-[#1D72B8] rounded-xl flex items-center justify-center" style="display:none;">
                            <i class="fas fa-book-open text-white text-xl"></i>
                        </div>
                    <?php else: ?>
                        <div class="w-12 h-12 bg-gradient-to-br from-[#0056FF] to-[#1D72B8] rounded-xl flex items-center justify-center">
                            <i class="fas fa-book-open text-white text-xl"></i>
                        </div>
                    <?php endif; ?>
                    <div>
                        <h1 class="text-xl font-bold font-display">EMANP</h1>
                        <p class="text-xs text-blue-200">Admin Panel</p>
                    </div>
                </div>
            </div>
            
            <!-- Scrollable Navigation -->
            <nav class="flex-1 overflow-y-auto overflow-x-hidden sidebar-scroll px-4 py-4 space-y-2">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-[#0056FF] transition-colors <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-[#0056FF]' : ''); ?>">
                    <i class="fas fa-tachometer-alt w-5"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="<?php echo e(route('admin.journals.index')); ?>" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-[#0056FF] transition-colors <?php echo e(request()->routeIs('admin.journals.*') ? 'bg-[#0056FF]' : ''); ?>">
                    <i class="fas fa-book w-5"></i>
                    <span>Journals</span>
                </a>
                
                <a href="<?php echo e(route('admin.journal-pages.index')); ?>" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-[#0056FF] transition-colors <?php echo e(request()->routeIs('admin.journal-pages.*') ? 'bg-[#0056FF]' : ''); ?>">
                    <i class="fas fa-file-alt w-5"></i>
                    <span>Journal Pages</span>
                </a>
                
                
                </a>
                
                <a href="<?php echo e(route('admin.submissions.index')); ?>" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-[#0056FF] transition-colors <?php echo e(request()->routeIs('admin.submissions.*') ? 'bg-[#0056FF]' : ''); ?>">
                    <i class="fas fa-file-alt w-5"></i>
                    <span>Articles & Submissions</span>
                </a>
                
                <a href="<?php echo e(route('admin.users.index')); ?>" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-[#0056FF] transition-colors <?php echo e(request()->routeIs('admin.users.*') ? 'bg-[#0056FF]' : ''); ?>">
                    <i class="fas fa-users w-5"></i>
                    <span>Users Management</span>
                </a>
                
                <a href="<?php echo e(route('admin.editorial-workflows.index')); ?>" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-[#0056FF] transition-colors <?php echo e(request()->routeIs('admin.editorial-workflows.*') ? 'bg-[#0056FF]' : ''); ?>">
                    <i class="fas fa-tasks w-5"></i>
                    <span>Editorial Workflows</span>
                </a>
                
                <a href="<?php echo e(route('admin.reviews.index')); ?>" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-[#0056FF] transition-colors <?php echo e(request()->routeIs('admin.reviews.*') ? 'bg-[#0056FF]' : ''); ?>">
                    <i class="fas fa-clipboard-check w-5"></i>
                    <span>Reviews</span>
                </a>
                
                <a href="<?php echo e(route('admin.issues.index')); ?>" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-[#0056FF] transition-colors <?php echo e(request()->routeIs('admin.issues.*') ? 'bg-[#0056FF]' : ''); ?>">
                    <i class="fas fa-bookmark w-5"></i>
                    <span>Issues & Volumes</span>
                </a>
                
                <a href="<?php echo e(route('admin.announcements.index')); ?>" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-[#0056FF] transition-colors <?php echo e(request()->routeIs('admin.announcements.*') ? 'bg-[#0056FF]' : ''); ?>">
                    <i class="fas fa-bullhorn w-5"></i>
                    <span>Announcements</span>
                </a>
                
                <a href="<?php echo e(route('admin.website-settings.index')); ?>" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-[#0056FF] transition-colors <?php echo e(request()->routeIs('admin.website-settings.*') ? 'bg-[#0056FF]' : ''); ?>">
                    <i class="fas fa-cog w-5"></i>
                    <span>Website Settings</span>
                </a>
                
                <div class="pt-2 pb-2">
                    <p class="px-4 text-xs text-blue-300 uppercase tracking-wider font-semibold mb-2">Page Builder</p>
                    <a href="<?php echo e(route('admin.page-builder.pages.index')); ?>" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-[#0056FF] transition-colors <?php echo e(request()->routeIs('admin.page-builder.*') ? 'bg-[#0056FF]' : ''); ?>">
                        <i class="fas fa-puzzle-piece w-5"></i>
                        <span>Custom Pages</span>
                    </a>
                    <a href="<?php echo e(route('admin.page-builder.widgets.index')); ?>" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-[#0056FF] transition-colors <?php echo e(request()->routeIs('admin.page-builder.*') ? 'bg-[#0056FF]' : ''); ?>">
                        <i class="fas fa-cubes w-5"></i>
                        <span>Widgets</span>
                    </a>
                </div>
                
                <a href="<?php echo e(route('admin.email-templates.index')); ?>" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-[#0056FF] transition-colors <?php echo e(request()->routeIs('admin.email-templates.*') ? 'bg-[#0056FF]' : ''); ?>">
                    <i class="fas fa-envelope w-5"></i>
                    <span>Email Templates</span>
                </a>
                
                    <a href="<?php echo e(route('admin.system-settings.index')); ?>" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-[#0056FF] transition-colors <?php echo e(request()->routeIs('admin.system-settings.*') ? 'bg-[#0056FF]' : ''); ?>">
                        <i class="fas fa-sliders-h w-5"></i>
                        <span>System Settings</span>
                    </a>
                    
                <a href="<?php echo e(route('admin.analytics.dashboard')); ?>" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-[#0056FF] transition-colors <?php echo e(request()->routeIs('admin.analytics.*') ? 'bg-[#0056FF]' : ''); ?>">
                    <i class="fas fa-chart-bar w-5"></i>
                    <span>Analytics</span>
                </a>
                
                <a href="<?php echo e(route('admin.statistics.enhanced')); ?>" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-[#0056FF] transition-colors <?php echo e(request()->routeIs('admin.statistics.*') ? 'bg-[#0056FF]' : ''); ?>">
                    <i class="fas fa-chart-line w-5"></i>
                    <span>Enhanced Statistics</span>
                </a>
                
                <a href="<?php echo e(route('admin.payments.index')); ?>" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-[#0056FF] transition-colors <?php echo e(request()->routeIs('admin.payments.*') ? 'bg-[#0056FF]' : ''); ?>">
                    <i class="fas fa-credit-card w-5"></i>
                    <span>Payments</span>
                </a>
                
                <div class="pt-2 pb-2">
                    <p class="px-4 text-xs text-blue-300 uppercase tracking-wider font-semibold mb-2">Advanced Features</p>
                    
                    <a href="<?php echo e(route('admin.review-forms.index')); ?>" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-[#0056FF] transition-colors <?php echo e(request()->routeIs('admin.review-forms.*') ? 'bg-[#0056FF]' : ''); ?>">
                        <i class="fas fa-clipboard-list w-5"></i>
                        <span>Review Forms</span>
                    </a>
                    
                    <a href="<?php echo e(route('admin.subscriptions.index')); ?>" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-[#0056FF] transition-colors <?php echo e(request()->routeIs('admin.subscriptions.*') ? 'bg-[#0056FF]' : ''); ?>">
                        <i class="fas fa-user-tag w-5"></i>
                        <span>Subscriptions</span>
                    </a>
                </div>
            </nav>
            
            <!-- Logout Button (Sticky Bottom) -->
            <div class="flex-shrink-0 p-6 border-t border-blue-800 bg-[#0F1B4C]">
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-red-600 transition-colors text-red-300">
                        <i class="fas fa-sign-out-alt w-5"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="bg-white shadow-md border-b border-gray-200">
                <div class="px-6 py-4 flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-[#0F1B4C]" style="font-family: 'Playfair Display', serif;">
                            <?php echo $__env->yieldContent('page-title', 'Admin Dashboard'); ?>
                        </h2>
                        <p class="text-sm text-gray-600"><?php echo $__env->yieldContent('page-subtitle', 'Manage your journal publishing platform'); ?></p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="<?php echo e(route('journals.index')); ?>" class="text-gray-600 hover:text-[#0056FF] transition-colors" title="View Website">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                        <div class="flex items-center space-x-3">
                            <div class="text-right">
                                <p class="text-sm font-semibold text-[#0F1B4C]"><?php echo e(auth()->user()->full_name); ?></p>
                                <p class="text-xs text-gray-500">Administrator</p>
                            </div>
                            <div class="w-10 h-10 bg-[#0056FF] rounded-full flex items-center justify-center text-white">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                <?php echo $__env->yieldContent('content'); ?>
            </main>
            
            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 mt-auto">
                <div class="px-6 py-4 text-center">
                    <p class="text-gray-500 text-sm mb-2">&copy; <?php echo e(date('Y')); ?> EMANP - Excellence in Management & Academic Network Publishing. All rights reserved.</p>
                </div>
            </footer>
        </div>
    </div>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>

<?php /**PATH C:\xampp\htdocs\cisa\resources\views/layouts/admin.blade.php ENDPATH**/ ?>