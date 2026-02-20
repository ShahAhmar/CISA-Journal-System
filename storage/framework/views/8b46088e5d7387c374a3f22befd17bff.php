<?php $__env->startSection('title', 'Publish With Us - CISA Interdisciplinary Journal (CIJ)'); ?>

<?php $__env->startSection('content'); ?>
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-purple-900 via-purple-800 to-purple-900 text-white py-20 overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 20px 20px;"></div>
    </div>
    <div class="absolute inset-0 bg-gradient-to-t from-purple-900/50 to-transparent"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center">
            <div class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full border border-white/20 mb-4">
                <i class="fas fa-globe text-yellow-300 mr-2 text-sm"></i>
                <span class="text-white text-sm font-semibold">Peer-Reviewed • Open Access • DOI Ready</span>
            </div>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4" style="font-family: 'Playfair Display', serif; letter-spacing: -0.02em;">
                Publish With CISA Interdisciplinary Journal (CIJ)
            </h1>
            <p class="text-xl md:text-2xl text-purple-100 mb-8 max-w-3xl mx-auto leading-relaxed">
                A Platform for Interdisciplinary Research Excellence — fast, rigorous peer review with global visibility in 5 languages.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="#why-publish" class="bg-white text-purple-700 px-8 py-4 rounded-xl font-semibold text-lg shadow-2xl hover:shadow-purple-500/50 transition-all duration-200 transform hover:scale-105">
                    <i class="fas fa-rocket mr-2"></i>Why Publish Here
                </a>
                <a href="<?php echo e(route('journals.index')); ?>" class="bg-white/10 hover:bg-white/20 text-white px-8 py-4 rounded-xl font-semibold text-lg border-2 border-white/30 transition-all duration-200">
                    <i class="fas fa-book-open mr-2"></i>Browse Journals
                </a>
            </div>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-white to-transparent"></div>
</section>

<!-- Stats Section -->
<section class="bg-white py-12 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="text-center">
                <div class="text-4xl md:text-5xl font-bold text-purple-700 mb-2" style="font-family: 'Playfair Display', serif;">
                    <?php echo e(number_format($stats['total_journals'] ?? 0)); ?>+
                </div>
                <div class="text-gray-600 font-semibold">Active Journals</div>
            </div>
            <div class="text-center">
                <div class="text-4xl md:text-5xl font-bold text-purple-700 mb-2" style="font-family: 'Playfair Display', serif;">
                    <?php echo e(number_format($stats['total_articles'] ?? 0)); ?>+
                </div>
                <div class="text-gray-600 font-semibold">Published Articles</div>
            </div>
            <div class="text-center">
                <div class="text-4xl md:text-5xl font-bold text-purple-700 mb-2" style="font-family: 'Playfair Display', serif;">
                    3-6
                </div>
                <div class="text-gray-600 font-semibold">Weeks Review Time</div>
            </div>
            <div class="text-center">
                <div class="text-4xl md:text-5xl font-bold text-purple-700 mb-2" style="font-family: 'Playfair Display', serif;">
                    5
                </div>
                <div class="text-gray-600 font-semibold">Supported Languages</div>
            </div>
        </div>
    </div>
</section>

<!-- Why Publish With Us Section -->
<section id="why-publish" class="bg-gradient-to-br from-purple-50 via-white to-purple-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <div class="inline-flex items-center px-4 py-2 bg-purple-100 rounded-full mb-4">
                <i class="fas fa-lightbulb text-purple-600 mr-2"></i>
                <span class="text-sm font-semibold text-purple-700">Why Publish With CIJ?</span>
            </div>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4" style="font-family: 'Playfair Display', serif; letter-spacing: -0.01em;">
                Fast, Rigorous, Global — Built for Interdisciplinary Research
            </h2>
            <p class="text-lg text-gray-600 mt-2 max-w-3xl mx-auto">
                Multilingual (EN/FR/ES/PT/SW), DOI-ready, open access, and a streamlined 3–6 week review pipeline backed by expert editors.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="bg-white rounded-xl p-8 border border-gray-200 hover:border-purple-300 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-600 to-purple-700 rounded-full flex items-center justify-center mb-6 shadow-md">
                    <i class="fas fa-check-double text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Rigorous Peer Review</h3>
                <p class="text-gray-600 leading-relaxed">
                    Double-blind reviews by subject experts; transparent feedback cycles to elevate quality.
                </p>
            </div>
            
            <div class="bg-white rounded-xl p-8 border border-gray-200 hover:border-purple-300 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-600 to-purple-700 rounded-full flex items-center justify-center mb-6 shadow-md">
                    <i class="fas fa-globe text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Open Access & DOI</h3>
                <p class="text-gray-600 leading-relaxed">
                    CC BY licensing, DOI-ready structure, and global reach in 5 supported languages.
                </p>
            </div>
            
            <div class="bg-white rounded-xl p-8 border border-gray-200 hover:border-purple-300 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-600 to-purple-700 rounded-full flex items-center justify-center mb-6 shadow-md">
                    <i class="fas fa-bolt text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Fast, Predictable Timelines</h3>
                <p class="text-gray-600 leading-relaxed">
                    Streamlined workflow with typical 3–6 week review windows and clear status updates.
                </p>
            </div>
            
            <div class="bg-white rounded-xl p-8 border border-gray-200 hover:border-purple-300 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-600 to-purple-700 rounded-full flex items-center justify-center mb-6 shadow-md">
                    <i class="fas fa-link text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Discovery & Indexing</h3>
                <p class="text-gray-600 leading-relaxed">
                    Metadata ready for indexing; ISSN/DOI support; optimized for discoverability and SEO.
                </p>
            </div>
            
            <div class="bg-white rounded-xl p-8 border border-gray-200 hover:border-purple-300 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-600 to-purple-700 rounded-full flex items-center justify-center mb-6 shadow-md">
                    <i class="fas fa-users text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Expert Editorial Team</h3>
                <p class="text-gray-600 leading-relaxed">
                    Editors and reviewers from diverse disciplines providing constructive, actionable feedback.
                </p>
            </div>
            
            <div class="bg-white rounded-xl p-8 border border-gray-200 hover:border-purple-300 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-600 to-purple-700 rounded-full flex items-center justify-center mb-6 shadow-md">
                    <i class="fas fa-language text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Multilingual Reach</h3>
                <p class="text-gray-600 leading-relaxed">
                    English, French, Spanish, Portuguese, Swahili — localized UI and messaging for broader reach.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <div class="inline-flex items-center px-4 py-2 bg-purple-50 rounded-full mb-4">
                <i class="fas fa-route text-purple-600 mr-2"></i>
                <span class="text-sm font-semibold text-purple-700">How It Works</span>
            </div>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3" style="font-family: 'Playfair Display', serif;">
                Submit. Review. Publish.
            </h2>
            <p class="text-lg text-gray-600 mt-2 max-w-3xl mx-auto">
                A streamlined submission workflow with clear steps, timelines, and DOI-enabled publication.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-20 h-20 bg-gradient-to-br from-purple-600 to-purple-700 rounded-full flex items-center justify-center mx-auto mb-6 text-white text-3xl font-bold" style="font-family: 'Playfair Display', serif;">
                    1
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Submit Your Manuscript</h3>
                <p class="text-gray-600 leading-relaxed">
                    Create your account, pick the right journal, and upload your files with clear metadata for faster processing.
                </p>
            </div>
            
            <div class="text-center">
                <div class="w-20 h-20 bg-gradient-to-br from-purple-600 to-purple-700 rounded-full flex items-center justify-center mx-auto mb-6 text-white text-3xl font-bold" style="font-family: 'Playfair Display', serif;">
                    2
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Peer Review & Revisions</h3>
                <p class="text-gray-600 leading-relaxed">
                    Double-blind review, constructive feedback, and revision cycles tracked in your dashboard.
                </p>
            </div>
            
            <div class="text-center">
                <div class="w-20 h-20 bg-gradient-to-br from-purple-600 to-purple-700 rounded-full flex items-center justify-center mx-auto mb-6 text-white text-3xl font-bold" style="font-family: 'Playfair Display', serif;">
                    3
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Publish & Disseminate</h3>
                <p class="text-gray-600 leading-relaxed">
                    DOI assigned, open-access publication, and multilingual discoverability across CIJ platforms.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Featured Journals Section -->
<section id="journals" class="bg-gradient-to-br from-purple-50 via-white to-purple-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <div class="inline-flex items-center px-4 py-2 bg-purple-100 rounded-full mb-4">
                <i class="fas fa-book-open text-purple-600 mr-2"></i>
                <span class="text-sm font-semibold text-purple-700">Our Journals</span>
            </div>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3" style="font-family: 'Playfair Display', serif;">
                Explore CIJ Journals
            </h2>
            <p class="text-lg text-gray-600 mt-2 max-w-3xl mx-auto">
                Peer-reviewed, interdisciplinary, and multilingual — find the right venue for your research.
            </p>
        </div>
        
        <?php if($journals->count() > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php $__currentLoopData = $journals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $journal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white rounded-2xl border border-gray-200 hover:border-purple-300 hover:shadow-xl transition-all duration-300 overflow-hidden transform hover:scale-[1.01]">
                        <div class="h-64 bg-white flex items-center justify-center relative overflow-hidden">
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
                        <div class="p-6 bg-white">
                            <h3 class="text-xl font-bold text-gray-900 mb-3 min-h-[3rem] leading-tight" style="font-family: 'Playfair Display', serif;"><?php echo e($journal->name); ?></h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2"><?php echo e(Str::limit($journal->description, 100)); ?></p>
                            <a href="<?php echo e(route('journals.show', $journal)); ?>" class="block w-full bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white text-center py-3 rounded-xl font-semibold transition-colors shadow-md hover:shadow-lg">
                                View Journal
                            </a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-xl p-16 text-center border-2 border-gray-200">
                <i class="fas fa-book-open text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-2xl font-bold text-gray-700 mb-2">No journals available yet</h3>
                <p class="text-gray-600">Check back soon for new journal publications.</p>
            </div>
        <?php endif; ?>
        
        <div class="text-center mt-12">
            <a href="<?php echo e(route('journals.index')); ?>" class="bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white px-8 py-4 rounded-xl font-semibold text-lg transition-colors shadow-lg transform hover:scale-105 inline-block">
                <i class="fas fa-arrow-right mr-2"></i>View All Journals
            </a>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="bg-gradient-to-br from-purple-900 via-purple-800 to-purple-900 text-white py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 20px 20px;"></div>
    </div>
    
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6" style="font-family: 'Playfair Display', serif; font-weight: 700;">
            Ready to Publish Your Research?
        </h2>
        <p class="text-xl text-purple-100 mb-8 leading-relaxed" style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.7;">
            Join our global community of researchers and make your work accessible to scholars worldwide. Start your submission today!
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('journals.index')); ?>" class="bg-white hover:bg-gray-100 text-purple-800 px-8 py-4 rounded-xl font-semibold text-lg transition-colors shadow-xl transform hover:scale-105">
                    <i class="fas fa-book-open mr-2"></i>Browse Journals
                </a>
            <?php else: ?>
                <a href="<?php echo e(route('register')); ?>" class="bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white px-8 py-4 rounded-xl font-semibold text-lg transition-colors shadow-xl transform hover:scale-105">
                    <i class="fas fa-user-plus mr-2"></i>Create Account
                </a>
                <a href="<?php echo e(route('login')); ?>" class="bg-white bg-opacity-10 hover:bg-opacity-20 text-white px-8 py-4 rounded-xl font-semibold text-lg transition-colors border-2 border-white border-opacity-30">
                    <i class="fas fa-sign-in-alt mr-2"></i>Login
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cisa\resources\views/publish/index.blade.php ENDPATH**/ ?>