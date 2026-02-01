

<?php $__env->startSection('title', 'CISA Interdisciplinary Journal (CIJ) - Premier Academic Publishing Platform'); ?>

<?php $__env->startSection('content'); ?>
    <!-- Hero Section -->
    <section class="relative min-h-[85vh] flex items-center justify-center overflow-hidden bg-cisa-base">
        <!-- Premium Background Image -->
        <div class="absolute inset-0 z-0">
            <img src="<?php echo e(asset('assets/images/portal-hero.png')); ?>"
                class="w-full h-full object-cover opacity-30 scale-105 animate-slow-zoom" alt="Academic Background">
            <!-- Darker Gradient to eliminate the "white shadow" at the bottom -->
            <div class="absolute inset-0 bg-gradient-to-b from-cisa-base via-cisa-base/60 to-cisa-base"></div>
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-5">
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 py-20 text-center">
            <!-- Announcement Badge -->
            <div
                class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-cisa-accent/10 border border-cisa-accent/20 mb-8 animate-fade-in">
                <span class="relative flex h-2 w-2">
                    <span
                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cisa-accent opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-cisa-accent"></span>
                </span>
                <span class="text-[10px] font-bold text-cisa-accent uppercase tracking-[0.2em]">New Journals Now Accepting
                    Submissions</span>
            </div>

            <h1
                class="text-2xl md:text-4xl lg:text-5xl font-bold font-serif text-white mb-6 leading-[1.1] animate-slide-up">
                Elevating <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-cisa-accent to-amber-500">Academic
                    Excellence</span> <br>
                Through Open Research
            </h1>

            <p class="text-sm md:text-base text-gray-300 mb-10 max-w-2xl mx-auto font-light leading-relaxed animate-slide-up"
                style="animation-delay: 0.1s;">
                A Pan-African platform for high-impact interdisciplinary research, fostering global collaboration and
                knowledge sharing.
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row justify-center items-center gap-4 mb-16 animate-slide-up"
                style="animation-delay: 0.2s;">
                <a href="#journals"
                    class="group px-8 py-3.5 bg-cisa-accent text-cisa-base font-bold rounded-full hover:bg-white transition-all duration-500 transform hover:-translate-y-1 shadow-2xl shadow-cisa-accent/30 text-sm uppercase tracking-widest flex items-center">
                    Get Started <i class="fas fa-arrow-right ml-2.5 group-hover:translate-x-1 transition-transform"></i>
                </a>
                <div class="relative group">
                    <form action="<?php echo e(route('search')); ?>" method="GET" class="flex items-center">
                        <input type="text" name="q" placeholder="Search publications..."
                            class="w-56 md:w-64 px-5 py-3.5 bg-white/5 border border-white/20 rounded-full text-white placeholder-gray-400 focus:outline-none focus:w-80 focus:bg-white/10 transition-all text-sm font-sans backdrop-blur-md">
                        <button type="submit" class="absolute right-5 text-gray-400 hover:text-cisa-accent">
                            <i class="fas fa-search text-sm"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Stats Bar -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 max-w-4xl mx-auto border-t border-white/10 pt-12 animate-slide-up"
                style="animation-delay: 0.3s;">
                <div class="text-center group px-4">
                    <div class="text-xl font-bold text-white font-serif mb-0.5">
                        <?php echo e(\App\Models\Journal::where('is_active', true)->count()); ?></div>
                    <div class="text-cisa-accent text-[9px] uppercase tracking-widest font-bold">Journals Published</div>
                </div>
                <div class="text-center group px-4 border-l border-white/5">
                    <div class="text-xl font-bold text-white font-serif mb-0.5">Double-Blind</div>
                    <div class="text-cisa-accent text-[9px] uppercase tracking-widest font-bold">Rigorous Review</div>
                </div>
                <div class="text-center group px-4 border-l border-white/5">
                    <div class="text-xl font-bold text-white font-serif mb-0.5">Open Access</div>
                    <div class="text-cisa-accent text-[9px] uppercase tracking-widest font-bold">Global Readership</div>
                </div>
                <div class="text-center group px-4 border-l border-white/5">
                    <div class="text-xl font-bold text-white font-serif mb-0.5">Impact Factor</div>
                    <div class="text-cisa-accent text-[9px] uppercase tracking-widest font-bold">High Visibility</div>
                </div>
            </div>
        </div>

        <!-- Animated Elements -->
        <style>
            @keyframes slow-zoom {
                0% {
                    transform: scale(1.0);
                }

                100% {
                    transform: scale(1.1);
                }
            }

            .animate-slow-zoom {
                animation: slow-zoom 7s linear infinite alternate;
            }
        </style>
    </section>

    <!-- Featured Journals Section -->
    <section id="journals" class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-cisa-accent font-bold tracking-widest text-sm uppercase">Our Collection</span>
                <h2 class="text-2xl md:text-3xl font-serif font-bold text-cisa-base mt-2 mb-6">Explore Our Publication</h2>
                <div class="w-24 h-1 bg-cisa-accent mx-auto"></div>
            </div>

            <?php if($journals->count() > 0): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <?php $__currentLoopData = $journals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $journal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div
                            class="group relative bg-white rounded-xl overflow-hidden active:scale-[0.98] transition-all duration-500 shadow-sm hover:shadow-xl border border-gray-100 flex flex-col h-full">
                            <!-- Premium Header Label -->
                            <div class="absolute top-3 left-3 z-20">
                                <span
                                    class="bg-cisa-base/80 backdrop-blur-md text-white text-[10px] font-bold px-3 py-1 rounded-full border border-white/20 uppercase tracking-widest">
                                    Peer Reviewed
                                </span>
                            </div>

                            <!-- Image/Cover Area (More Slender) -->
                            <div class="relative h-44 overflow-hidden bg-slate-900">
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-cisa-base via-transparent to-transparent z-10 opacity-80 group-hover:opacity-60 transition-opacity duration-500">
                                </div>

                                <?php if($journal->cover_image): ?>
                                    <img src="<?php echo e(asset('storage/' . $journal->cover_image)); ?>" alt="<?php echo e($journal->name); ?>"
                                        class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 ease-out">
                                <?php else: ?>
                                    <div
                                        class="w-full h-full flex items-center justify-center bg-gradient-to-br from-cisa-light to-cisa-base opacity-40">
                                        <i class="fas fa-book-open text-6xl text-white/20"></i>
                                    </div>
                                <?php endif; ?>

                                <!-- Impact Badge -->
                                <div class="absolute bottom-6 left-8 z-20">
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="w-10 h-10 rounded-full bg-cisa-accent flex items-center justify-center text-cisa-base shadow-lg">
                                            <i class="fas fa-chart-line text-xs"></i>
                                        </div>
                                        <div>
                                            <div
                                                class="text-[10px] text-gray-300 font-bold uppercase tracking-widest leading-none mb-1">
                                                Impact Factor</div>
                                            <div class="text-white font-bold text-lg leading-none">
                                                <?php echo e(number_format($journal->impact_factor ?? 2.5, 2)); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Info Content -->
                            <div class="p-8 pb-10 flex-grow flex flex-col bg-white relative">
                                <div class="mb-4">
                                    <?php if($journal->issn_online): ?>
                                        <span class="text-[10px] font-bold text-gray-400 tracking-widest uppercase mb-2 block">
                                            E-ISSN: <?php echo e($journal->issn_online); ?>

                                        </span>
                                    <?php endif; ?>
                                    <h3
                                        class="text-xl font-bold text-cisa-base font-serif leading-tight group-hover:text-cisa-accent transition-colors">
                                        <a href="<?php echo e(route('journals.show', $journal)); ?>">
                                            <?php echo e($journal->name); ?>

                                        </a>
                                    </h3>
                                </div>

                                <p class="text-gray-500 text-sm mb-8 flex-grow leading-relaxed font-light italic">
                                    "<?php echo e(Str::limit(strip_tags($journal->description ?: 'International peer-reviewed journal dedicated to advancing knowledge across global disciplines.'), 120)); ?>"
                                </p>

                                <div class="flex items-center justify-between pt-6 border-t border-gray-50">
                                    <a href="<?php echo e(route('journals.show', $journal)); ?>"
                                        class="inline-flex items-center text-xs font-bold text-cisa-base tracking-[0.2em] uppercase group/btn hover:text-cisa-accent transition-colors">
                                        Explore Journal
                                        <div
                                            class="ml-3 w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center group-hover/btn:border-cisa-accent group-hover/btn:bg-cisa-accent group-hover/btn:text-cisa-base transition-all">
                                            <i class="fas fa-arrow-right text-[10px]"></i>
                                        </div>
                                    </a>

                                    <div class="flex -space-x-2">
                                        <div class="w-8 h-8 rounded-full bg-slate-50 border-2 border-white flex items-center justify-center text-gray-400 text-xs"
                                            title="Open Access">
                                            <i class="fas fa-lock-open"></i>
                                        </div>
                                        <div class="w-8 h-8 rounded-full bg-slate-50 border-2 border-white flex items-center justify-center text-gray-400 text-xs"
                                            title="DOAJ Indexed">
                                            <i class="fas fa-check"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="text-center mt-16">
                    <a href="<?php echo e(route('journals.index')); ?>" class="btn-cisa-outline text-lg px-10 py-4">
                        Explore Full Library
                    </a>
                </div>
            <?php else: ?>
                <div class="text-center py-20 bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-300">
                        <i class="fas fa-book-open text-3xl"></i>
                    </div>
                    <h3 class="text-xl text-gray-600 font-serif">No journals available at the moment.</h3>
                    <p class="text-gray-400 mt-2">Our collection is being updated.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Subject Areas Section -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
                <div class="max-w-xl">
                    <span class="text-cisa-accent font-bold tracking-widest text-[10px] uppercase">Research Fields</span>
                    <h2 class="text-3xl font-serif font-bold text-cisa-base mt-2">Explore by Subject</h2>
                </div>
                <p class="text-gray-500 font-light max-w-sm">Discover specialized research across our diverse collection of
                    interdisciplinary journals.</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
                <?php
                    $subjects = [
                        ['icon' => 'fa-microscope', 'label' => 'Technology'],
                        ['icon' => 'fa-users', 'label' => 'Social Sciences'],
                        ['icon' => 'fa-briefcase', 'label' => 'Business'],
                        ['icon' => 'fa-medkit', 'label' => 'Medicine'],
                        ['icon' => 'fa-scale-balanced', 'label' => 'Law'],
                        ['icon' => 'fa-graduation-cap', 'label' => 'Education'],
                    ];
                ?>

                <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('search', ['category' => $subject['label']])); ?>"
                        class="group p-8 bg-slate-50 rounded-2xl border border-transparent hover:border-cisa-accent/30 hover:bg-white hover:shadow-xl transition-all duration-300 text-center">
                        <div
                            class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-gray-400 group-hover:text-cisa-accent group-hover:bg-cisa-accent/10 mx-auto mb-4 transition-colors shadow-sm">
                            <i class="fas <?php echo e($subject['icon']); ?> text-lg"></i>
                        </div>
                        <span
                            class="text-xs font-bold text-gray-600 group-hover:text-cisa-base uppercase tracking-widest transition-colors"><?php echo e($subject['label']); ?></span>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>

    <!-- Values Section (Modern Dark) -->
    <section class="py-24 bg-cisa-base text-white relative overflow-hidden">
        <!-- Abstract Decoration -->
        <div class="absolute inset-0 z-0 opacity-30 pointer-events-none">
            <div class="absolute top-0 left-1/4 w-px h-full bg-gradient-to-b from-transparent via-white/10 to-transparent">
            </div>
            <div class="absolute top-0 left-2/4 w-px h-full bg-gradient-to-b from-transparent via-white/10 to-transparent">
            </div>
            <div class="absolute top-0 left-3/4 w-px h-full bg-gradient-to-b from-transparent via-white/10 to-transparent">
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-20">
                <h2 class="text-3xl font-serif font-bold text-white mb-4">Why Publish With Us?</h2>
                <p class="text-gray-400 max-w-2xl mx-auto font-light text-sm">Join a global network of scholars committed to
                    advancing high-impact interdisciplinary research.</p>
            </div>

            <div
                class="grid grid-cols-1 md:grid-cols-3 gap-0 border border-white/10 rounded-3xl overflow-hidden bg-white/5 backdrop-blur-sm">
                <div class="p-12 md:border-r border-white/10 hover:bg-white/5 transition-colors duration-500">
                    <div
                        class="w-16 h-16 bg-cisa-accent/10 rounded-2xl flex items-center justify-center text-cisa-accent text-3xl mb-8">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 font-serif">Rapid Publication</h3>
                    <p class="text-gray-400 leading-relaxed font-light">
                        Our streamlined editorial workflow ensures that your research reaches the global audience within 4-6
                        weeks of submission.
                    </p>
                </div>

                <div class="p-12 md:border-r border-white/10 hover:bg-white/5 transition-colors duration-500">
                    <div
                        class="w-16 h-16 bg-cisa-accent/10 rounded-2xl flex items-center justify-center text-cisa-accent text-3xl mb-8">
                        <i class="fas fa-globe-africa"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 font-serif">Pan-African Rooted</h3>
                    <p class="text-gray-400 leading-relaxed font-light">
                        While global in reach, we provide a specialized platform for African-centric research and
                        perspectives to gain international visibility.
                    </p>
                </div>

                <div class="p-12 hover:bg-white/5 transition-colors duration-500">
                    <div
                        class="w-16 h-16 bg-cisa-accent/10 rounded-2xl flex items-center justify-center text-cisa-accent text-3xl mb-8">
                        <i class="fas fa-check-double"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 font-serif">Rigorous Standard</h3>
                    <p class="text-gray-400 leading-relaxed font-light">
                        Every paper undergoes a strict double-blind peer review process, maintaining the highest levels of
                        academic integrity.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-32 bg-slate-50 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-gray-200 to-transparent"></div>

        <div class="max-w-5xl mx-auto px-4 text-center relative z-10">
            <div
                class="inline-block px-4 py-1.5 bg-cisa-base text-white text-[10px] font-bold rounded-full mb-8 tracking-[0.3em] uppercase">
                Contribution
            </div>
            <h2 class="text-4xl md:text-5xl font-serif font-bold text-cisa-base mb-8 leading-tight">Ready to Advance
                <br>Your Research?</h2>
            <p class="text-lg text-gray-500 mb-12 max-w-2xl mx-auto font-light leading-relaxed">
                Join our prestigious community of researchers and scholars. Submit your original work to one of our
                peer-reviewed journals today.
            </p>
            <div class="flex flex-col sm:flex-row justify-center items-center gap-6">
                <a href="<?php echo e(route('register')); ?>"
                    class="group px-12 py-5 bg-cisa-base text-white font-bold rounded-full hover:bg-cisa-accent hover:text-cisa-base transition-all duration-500 shadow-xl hover:shadow-cisa-accent/20 text-base uppercase tracking-widest flex items-center">
                    Submit Manuscript <i
                        class="fas fa-paper-plane ml-3 group-hover:-translate-y-1 group-hover:translate-x-1 transition-transform"></i>
                </a>
                <a href="#"
                    class="inline-flex items-center text-sm font-bold text-cisa-base hover:text-cisa-accent transition-colors tracking-widest uppercase py-4 px-6 border border-gray-200 rounded-full hover:border-cisa-accent">
                    Author Guidelines <i class="fas fa-file-pdf ml-2"></i>
                </a>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u857061584/domains/cisajournal.org/public_html/resources/views/journals/index.blade.php ENDPATH**/ ?>