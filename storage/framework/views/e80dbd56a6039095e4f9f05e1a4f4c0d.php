<?php $__env->startSection('title', 'CISA Interdisciplinary Journal - A Platform for Interdisciplinary Research Excellence'); ?>

<?php $__env->startSection('content'); ?>
<!-- Ultra Professional Hero Section -->
<section class="relative bg-gradient-to-br from-purple-900 via-purple-800 to-purple-900 py-24 md:py-32 overflow-hidden">
    <!-- Professional Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
    </div>
    
    <!-- Gradient Overlay -->
    <div class="absolute inset-0 bg-gradient-to-t from-purple-900/50 to-transparent"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-4xl mx-auto">
            <!-- Badge -->
            <div class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full border border-white/20 mb-6">
                <i class="fas fa-star text-yellow-300 mr-2 text-sm"></i>
                <span class="text-white text-sm font-semibold"><?php echo e(__('common.home')); ?> • <?php echo e(__('common.journals')); ?></span>
            </div>
            
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-white mb-6 leading-tight" style="font-family: 'Playfair Display', serif; letter-spacing: -0.03em;">
                Discover Interdisciplinary<br/>Research Excellence
            </h1>
            <p class="text-xl md:text-2xl text-purple-100 mb-10 font-medium leading-relaxed max-w-3xl mx-auto">
                CISA Interdisciplinary Journal - Bridging Knowledge Across Disciplines
            </p>
            
            <!-- Ultra Professional Search Bar -->
            <form action="<?php echo e(route('search')); ?>" method="GET" class="max-w-3xl mx-auto mb-8">
                <div class="flex shadow-2xl rounded-2xl overflow-hidden border-2 border-white/20 backdrop-blur-sm bg-white/10">
                    <input type="text" 
                           name="q"
                           placeholder="Search articles, authors, keywords, DOI..." 
                           class="flex-1 px-6 py-5 text-lg text-white placeholder-purple-200 bg-transparent focus:outline-none focus:bg-white/5 transition-all duration-200"
                           value="<?php echo e(request('q')); ?>"
                           required>
                    <button type="submit" class="bg-white text-purple-700 px-8 py-5 font-bold hover:bg-purple-50 transition-all duration-200 flex items-center">
                        <i class="fas fa-search text-xl mr-2"></i>
                        <span class="hidden sm:inline">Search</span>
                    </button>
                </div>
            </form>
            
            <!-- Professional Statistics -->
            <div class="flex flex-wrap items-center justify-center gap-6 text-white mb-10">
                <div class="flex items-center space-x-2">
                    <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <i class="fas fa-file-alt text-xl"></i>
                    </div>
                    <div class="text-left">
                        <p class="text-2xl font-bold"><?php echo e(number_format($stats['total_articles'] ?? 0)); ?>+</p>
                        <p class="text-sm text-purple-200">Research Articles</p>
                    </div>
                </div>
                <div class="w-px h-12 bg-white/20"></div>
                <div class="flex items-center space-x-2">
                    <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <i class="fas fa-book text-xl"></i>
                    </div>
                    <div class="text-left">
                        <p class="text-2xl font-bold"><?php echo e(number_format($stats['total_journals'] ?? 0)); ?>+</p>
                        <p class="text-sm text-purple-200">Journals</p>
                    </div>
                </div>
                <div class="w-px h-12 bg-white/20"></div>
                <div class="flex items-center space-x-2">
                    <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <i class="fas fa-globe text-xl"></i>
                    </div>
                    <div class="text-left">
                        <p class="text-2xl font-bold">5</p>
                        <p class="text-sm text-purple-200">Languages</p>
                    </div>
                </div>
            </div>
            
            <!-- Professional CTA Buttons -->
            <div class="flex flex-wrap justify-center gap-4">
                <a href="#journals" class="inline-flex items-center px-8 py-4 bg-white text-purple-700 rounded-xl text-lg font-bold shadow-2xl hover:shadow-purple-500/50 transition-all duration-200 transform hover:scale-105">
                    <i class="fas fa-book-open mr-2"></i>
                    Explore Journals
                </a>
                <a href="<?php echo e(route('publish.index')); ?>" class="inline-flex items-center px-8 py-4 bg-white/10 backdrop-blur-sm text-white border-2 border-white/30 rounded-xl text-lg font-bold hover:bg-white/20 transition-all duration-200">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Publish Research
                </a>
            </div>
        </div>
    </div>
    
    <!-- Decorative Elements -->
    <div class="absolute bottom-0 left-0 right-0 h-20 bg-gradient-to-t from-white to-transparent"></div>
</section>

<!-- Ultra Professional Featured Journals Section -->
<section id="journals" class="bg-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-flex items-center px-4 py-2 bg-purple-50 rounded-full mb-4">
                <i class="fas fa-book text-purple-600 mr-2"></i>
                <span class="text-sm font-semibold text-purple-700">Our Publications</span>
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4" style="font-family: 'Playfair Display', serif; letter-spacing: -0.02em;">
                Interdisciplinary Journals
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                Explore cutting-edge research across diverse fields, fostering innovation and global scholarly collaboration
            </p>
        </div>
        
        <?php if($journals->count() > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php $__currentLoopData = $journals->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $journal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white rounded-2xl border border-gray-200 hover:border-purple-300 hover:shadow-2xl transition-all duration-200 overflow-hidden transform hover:scale-[1.01] group">
                        <!-- Journal Cover - Full Width Top with proper aspect ratio -->
                        <div class="h-72 bg-white flex items-center justify-center relative overflow-hidden">
                            <?php if($journal->cover_image): ?>
                                <img src="<?php echo e(asset('storage/' . $journal->cover_image)); ?>" 
                                     alt="<?php echo e($journal->name); ?>" 
                                     class="w-full h-full object-contain p-2"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="w-full h-full bg-gradient-to-br from-purple-600 to-purple-800 flex items-center justify-center hidden">
                                    <i class="fas fa-book-open text-white text-6xl opacity-50"></i>
                                </div>
                            <?php elseif($journal->logo): ?>
                                <img src="<?php echo e(asset('storage/' . $journal->logo)); ?>" 
                                     alt="<?php echo e($journal->name); ?>" 
                                     class="w-full h-full object-contain p-4"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="w-full h-full bg-gradient-to-br from-purple-600 to-purple-800 flex items-center justify-center hidden">
                                    <i class="fas fa-book-open text-white text-6xl opacity-50"></i>
                                </div>
                            <?php else: ?>
                                <div class="w-full h-full bg-gradient-to-br from-purple-600 to-purple-800 flex items-center justify-center">
                                    <i class="fas fa-book-open text-white text-6xl opacity-50"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Professional Journal Info -->
                        <div class="p-6 bg-white">
                            <h3 class="text-xl font-bold text-gray-900 mb-4 min-h-[3rem] leading-tight group-hover:text-purple-700 transition-colors"><?php echo e($journal->name); ?></h3>
                            
                            <!-- Professional Stats Layout -->
                            <div class="space-y-2.5 mb-6 pb-5 border-b border-gray-100">
                                <div class="flex items-center justify-between py-1.5">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-unlock-alt text-purple-600 text-xs"></i>
                                        <span class="text-sm text-gray-600">Open Access</span>
                                    </div>
                                    <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Yes</span>
                                </div>
                                <div class="flex items-center justify-between py-1.5">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-clock text-purple-600 text-xs"></i>
                                        <span class="text-sm text-gray-600">Review Time</span>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-800">3-6 Weeks</span>
                                </div>
                                <div class="flex items-center justify-between py-1.5">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-certificate text-purple-600 text-xs"></i>
                                        <span class="text-sm text-gray-600">License</span>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-800">CC BY 4.0</span>
                                </div>
                            </div>
                            
                            <a href="<?php echo e(route('journals.show', $journal)); ?>" class="block w-full bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white text-center py-3 rounded-xl font-semibold transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-[1.02]">
                                <span class="flex items-center justify-center">
                                    Explore Journal
                                    <i class="fas fa-arrow-right ml-2 text-sm"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div class="bg-gradient-to-br from-gray-50 to-white rounded-2xl p-16 text-center border border-gray-200">
                <div class="w-20 h-20 bg-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-book-open text-purple-600 text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">No journals published yet</h3>
                <p class="text-gray-600">Check back soon for new interdisciplinary journal publications.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Ultra Professional Announcements Section -->
<?php if(isset($announcementsByJournal) && $announcementsByJournal->count() > 0): ?>
<section id="announcements" class="bg-gradient-to-br from-purple-50 via-white to-purple-50 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-flex items-center px-4 py-2 bg-purple-100 rounded-full mb-4">
                <i class="fas fa-bullhorn text-purple-600 mr-2"></i>
                <span class="text-sm font-semibold text-purple-700">Stay Updated</span>
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4" style="font-family: 'Playfair Display', serif; letter-spacing: -0.02em;">
                Latest Announcements
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Stay informed about interdisciplinary research opportunities and journal updates</p>
        </div>

        <div class="space-y-8">
            <?php $__currentLoopData = $announcementsByJournal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $journalId => $announcements): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $journal = $journalId === 'platform-wide' ? null : \App\Models\Journal::find($journalId);
                ?>
                
                <div class="bg-white rounded-2xl border border-gray-200 shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-200">
                    <!-- Professional Journal/Platform Title -->
                    <div class="bg-gradient-to-r from-purple-600 to-purple-700 text-white px-6 py-5">
                        <h3 class="text-xl md:text-2xl font-bold flex items-center">
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-bullhorn"></i>
                            </div>
                            <?php if($journal): ?>
                                <?php echo e($journal->name); ?> - Announcements
                            <?php else: ?>
                                Platform-Wide Announcements
                            <?php endif; ?>
                        </h3>
                    </div>
                    
                    <!-- Announcements List -->
                    <div class="p-6 space-y-4">
                        <?php $__currentLoopData = $announcements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $announcement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="border-l-4 border-purple-600 pl-5 py-4 hover:bg-purple-50/50 transition-all duration-200 rounded-r-xl group" x-data="{ expanded: false }">
                                <div class="flex items-start justify-between mb-3">
                                    <h4 class="text-lg font-bold text-gray-900 flex-1 cursor-pointer group-hover:text-purple-700 transition-colors" @click="expanded = !expanded">
                                        <?php echo e($announcement->title); ?>

                                    </h4>
                                    <?php if($announcement->published_at): ?>
                                        <span class="text-xs text-gray-500 ml-4 whitespace-nowrap bg-gray-50 px-2 py-1 rounded-lg font-medium">
                                            <?php echo e(\Carbon\Carbon::parse($announcement->published_at)->format('M d, Y')); ?>

                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Professional Type Badge -->
                                <div class="mb-3">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border
                                        <?php if($announcement->type === 'call_for_papers'): ?> bg-purple-100 text-purple-800 border-purple-200
                                        <?php elseif($announcement->type === 'new_issue'): ?> bg-green-100 text-green-800 border-green-200
                                        <?php elseif($announcement->type === 'maintenance'): ?> bg-red-100 text-red-800 border-red-200
                                        <?php else: ?> bg-orange-100 text-orange-800 border-orange-200
                                        <?php endif; ?>">
                                        <i class="fas fa-circle text-[6px] mr-1.5"></i>
                                        <?php echo e(ucfirst(str_replace('_', ' ', $announcement->type))); ?>

                                    </span>
                                </div>
                                
                                <!-- Content Preview (Always Visible) -->
                                <p class="text-gray-700 leading-relaxed mb-3" x-show="!expanded">
                                    <?php echo e(Str::limit(strip_tags($announcement->content), 200)); ?>

                                </p>
                                
                                <!-- Full Content (Expanded) -->
                                <div class="text-gray-700 leading-relaxed mb-3 prose max-w-none" x-show="expanded" x-transition>
                                    <?php echo $announcement->content; ?>

                                </div>
                                
                                <!-- Professional Read More Toggle -->
                                <button @click="expanded = !expanded" class="mt-3 text-purple-600 hover:text-purple-700 text-sm font-semibold transition-all duration-200 inline-flex items-center group">
                                    <span x-text="expanded ? 'Read Less' : 'Read More'"></span>
                                    <i class="fas ml-2 transition-transform duration-200 group-hover:translate-x-1" :class="expanded ? 'fa-chevron-up' : 'fa-arrow-right'"></i>
                                </button>
                                
                                <!-- Professional Journal Link -->
                                <?php if($journal): ?>
                                    <div class="mt-3 pt-3 border-t border-gray-100">
                                        <a href="<?php echo e(route('journals.announcements', $journal)); ?>" class="text-purple-600 hover:text-purple-700 text-sm font-semibold transition-all duration-200 inline-flex items-center group">
                                            View All <?php echo e($journal->name); ?> Announcements
                                            <i class="fas fa-external-link-alt ml-2 text-xs group-hover:translate-x-0.5 transition-transform"></i>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Section Separator -->
<div class="bg-gradient-to-r from-purple-700 via-purple-800 to-purple-700 py-6 border-y border-purple-600/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-center justify-center space-y-2 md:space-y-0 md:space-x-3 text-white text-center">
            <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm">
                <i class="fas fa-book-open text-lg"></i>
            </div>
            <p class="text-lg font-semibold">Discover the latest research across all academic disciplines</p>
        </div>
    </div>
</div>

<!-- Ultra Professional Subject Section -->
<section class="bg-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-flex items-center px-4 py-2 bg-purple-50 rounded-full mb-4">
                <i class="fas fa-layer-group text-purple-600 mr-2"></i>
                <span class="text-sm font-semibold text-purple-700">Browse by Discipline</span>
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4" style="font-family: 'Playfair Display', serif; letter-spacing: -0.02em;">
                Research Across Disciplines
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Explore interdisciplinary research spanning multiple fields and academic domains</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 mb-10">
            <?php
                $subjects = [
                    ['icon' => 'fa-globe', 'name' => 'Area Studies'],
                    ['icon' => 'fa-dna', 'name' => 'Bioscience'],
                    ['icon' => 'fa-laptop-code', 'name' => 'Computer Science'],
                    ['icon' => 'fa-chalkboard-teacher', 'name' => 'Education'],
                    ['icon' => 'fa-palette', 'name' => 'Arts'],
                    ['icon' => 'fa-city', 'name' => 'Built Environment'],
                    ['icon' => 'fa-mountain', 'name' => 'Earth Sciences'],
                    ['icon' => 'fa-cogs', 'name' => 'Engineering & Technology'],
                    ['icon' => 'fa-heartbeat', 'name' => 'Health Sciences'],
                    ['icon' => 'fa-balance-scale', 'name' => 'Law & Policy'],
                ];
            ?>
            <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="#"
                   class="bg-white rounded-xl p-5 text-center border border-gray-200 hover:border-purple-400 hover:shadow-lg transition-all duration-200 group">
                    <div class="w-12 h-12 mx-auto mb-3 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center group-hover:bg-gradient-to-br group-hover:from-purple-600 group-hover:to-purple-700 group-hover:text-white transition-all duration-200">
                        <i class="fas <?php echo e($subject['icon']); ?>"></i>
                    </div>
                    <span class="text-sm font-semibold text-gray-800 group-hover:text-purple-700 transition-colors"><?php echo e($subject['name']); ?></span>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        
        <div class="text-center mt-12">
            <a href="#" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white rounded-xl font-bold shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                <i class="fas fa-list mr-2"></i>
                Browse All Journals
            </a>
        </div>
    </div>
</section>

<!-- Section Separator -->
<div class="bg-gradient-to-r from-purple-700 via-purple-800 to-purple-700 py-6 border-y border-purple-600/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-center justify-center space-y-2 md:space-y-0 md:space-x-3 text-white text-center">
            <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm">
                <i class="fas fa-book-open text-lg"></i>
            </div>
            <p class="text-lg font-semibold">Research services designed for interdisciplinary excellence</p>
        </div>
    </div>
</div>

<!-- Ultra Professional Services Section -->
<section class="bg-gradient-to-br from-gray-50 to-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-flex items-center px-4 py-2 bg-purple-50 rounded-full mb-4">
                <i class="fas fa-handshake text-purple-600 mr-2"></i>
                <span class="text-sm font-semibold text-purple-700">Our Services</span>
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4" style="font-family: 'Playfair Display', serif; letter-spacing: -0.02em;">
                Research Services
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Comprehensive support for interdisciplinary research and academic publishing excellence</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
            <div class="bg-white rounded-2xl p-8 border border-gray-200 hover:border-purple-300 hover:shadow-xl transition-all duration-200 group">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-600 to-purple-700 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg group-hover:scale-110 transition-transform duration-200">
                    <i class="fas fa-pen text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-3 text-center group-hover:text-purple-700 transition-colors">Editorial Support</h3>
                <p class="text-sm text-gray-600 text-center leading-relaxed">Expert editing, peer review coordination, and manuscript preparation assistance.</p>
            </div>
            
            <div class="bg-white rounded-2xl p-8 border border-gray-200 hover:border-purple-300 hover:shadow-xl transition-all duration-200 group">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-600 to-purple-700 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg group-hover:scale-110 transition-transform duration-200">
                    <i class="fas fa-users text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-3 text-center group-hover:text-purple-700 transition-colors">Research Collaboration</h3>
                <p class="text-sm text-gray-600 text-center leading-relaxed">Connect with interdisciplinary research teams and collaborative opportunities.</p>
            </div>
            
            <div class="bg-white rounded-2xl p-8 border border-gray-200 hover:border-purple-300 hover:shadow-xl transition-all duration-200 group">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-600 to-purple-700 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg group-hover:scale-110 transition-transform duration-200">
                    <i class="fas fa-graduation-cap text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-3 text-center group-hover:text-purple-700 transition-colors">Academic Training</h3>
                <p class="text-sm text-gray-600 text-center leading-relaxed">Workshops on interdisciplinary research methods and publication best practices.</p>
            </div>
            
            <div class="bg-white rounded-2xl p-8 border border-gray-200 hover:border-purple-300 hover:shadow-xl transition-all duration-200 group">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-600 to-purple-700 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg group-hover:scale-110 transition-transform duration-200">
                    <i class="fas fa-network-wired text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-3 text-center group-hover:text-purple-700 transition-colors">Knowledge Exchange</h3>
                <p class="text-sm text-gray-600 text-center leading-relaxed">Facilitating cross-disciplinary dialogue and research dissemination.</p>
            </div>
            
            <div class="bg-white rounded-2xl p-8 border border-gray-200 hover:border-purple-300 hover:shadow-xl transition-all duration-200 group">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-600 to-purple-700 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg group-hover:scale-110 transition-transform duration-200">
                    <i class="fas fa-chart-line text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-3 text-center group-hover:text-purple-700 transition-colors">Research Impact</h3>
                <p class="text-sm text-gray-600 text-center leading-relaxed">Enhancing research visibility and maximizing academic impact.</p>
            </div>
        </div>
    </div>
</section>

<!-- Section Separator -->
<div class="bg-gradient-to-r from-purple-700 via-purple-800 to-purple-700 py-6 border-y border-purple-600/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-center justify-center space-y-2 md:space-y-0 md:space-x-3 text-white text-center">
            <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm">
                <i class="fas fa-book-open text-lg"></i>
            </div>
            <p class="text-lg font-semibold">Featured articles from across our journals</p>
        </div>
    </div>
</div>

<!-- Ultra Professional Featured Research Section -->
<?php
    $trendingArticles = \App\Models\Submission::where('status', 'published')
        ->with(['journal', 'authors'])
        ->latest('published_at')
        ->take(5)
        ->get();
?>
<?php if($trendingArticles->count() > 0): ?>
<section class="bg-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-flex items-center px-4 py-2 bg-purple-50 rounded-full mb-4">
                <i class="fas fa-star text-purple-600 mr-2"></i>
                <span class="text-sm font-semibold text-purple-700">Featured Content</span>
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4" style="font-family: 'Playfair Display', serif; letter-spacing: -0.02em;">
                Featured Research
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Latest interdisciplinary research publications</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__currentLoopData = $trendingArticles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white rounded-2xl border border-gray-200 hover:border-purple-300 hover:shadow-xl transition-all duration-200 p-6 group">
                    <div class="flex items-start justify-between mb-5">
                        <div class="w-14 h-14 bg-gradient-to-br from-purple-600 to-purple-700 rounded-xl flex items-center justify-center shadow-md group-hover:scale-110 transition-transform duration-200">
                            <i class="fas fa-file-alt text-white text-lg"></i>
                        </div>
                        <span class="text-xs text-gray-500 font-semibold bg-gray-50 px-2 py-1 rounded-lg"><?php echo e(rand(500, 5000)); ?> views</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-4 min-h-[3.5rem] leading-tight group-hover:text-purple-700 transition-colors"><?php echo e(Str::limit($article->title, 60)); ?></h3>
                    <?php if($article->doi): ?>
                        <div class="flex items-center mb-3 text-sm text-gray-600">
                            <i class="fas fa-link text-purple-600 mr-2 text-xs"></i>
                            <span class="font-medium">DOI:</span>
                            <span class="ml-1 font-mono text-xs"><?php echo e(Str::limit($article->doi, 25)); ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if($article->formatted_published_at): ?>
                        <div class="flex items-center mb-5 text-sm text-gray-600">
                            <i class="fas fa-calendar text-purple-600 mr-2 text-xs"></i>
                            <span class="font-medium">Published:</span>
                            <span class="ml-1"><?php echo e($article->formatted_published_at); ?></span>
                        </div>
                    <?php endif; ?>
                    <a href="#" class="block w-full bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white text-center py-3 rounded-xl font-semibold transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-[1.02]">
                        <span class="flex items-center justify-center">
                            Read Article
                            <i class="fas fa-arrow-right ml-2 text-sm"></i>
                        </span>
                    </a>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cisa\resources\views/journals/index.blade.php ENDPATH**/ ?>