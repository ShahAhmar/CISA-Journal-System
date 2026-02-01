

<?php $__env->startSection('title', 'Publish With Us - CISA Interdisciplinary Journal'); ?>

<?php $__env->startSection('content'); ?>
    <!-- Hero Section -->
    <section class="relative min-h-[60vh] flex items-center justify-center overflow-hidden bg-cisa-base">
        <div class="absolute inset-0 z-0 opacity-20">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
            <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-cisa-light to-transparent"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 py-20 text-center">
            <span class="text-cisa-accent font-bold tracking-widest text-sm uppercase mb-4 block">Call for Papers</span>
            <h1 class="text-4xl md:text-6xl font-bold font-serif text-white mb-6 leading-tight">
                Share Your Research with <br>
                <span class="text-cisa-accent">Global Scholars</span>
            </h1>

            <p class="text-xl text-gray-300 mb-10 max-w-3xl mx-auto font-light leading-relaxed">
                Publish your groundbreaking research in our prestigious interdisciplinary journals. Reach millions of
                researchers and accelerate the impact of your work.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="#why-publish" class="btn-cisa-primary text-lg px-8 py-4 shadow-lg">
                    Why Publish With Us?
                </a>
                <a href="#journals"
                    class="btn-cisa-outline text-white border-white hover:bg-white hover:text-cisa-base text-lg px-8 py-4">
                    View Journals
                </a>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="bg-white py-16 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 divide-x divide-gray-100">
                <div class="text-center">
                    <div class="text-4xl font-bold font-serif text-cisa-base mb-2">
                        <?php echo e(number_format($stats['total_journals'] ?? 0)); ?>+</div>
                    <div class="text-cisa-muted font-medium uppercase text-xs tracking-wider">Active Journals</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold font-serif text-cisa-base mb-2">
                        <?php echo e(number_format($stats['total_articles'] ?? 0)); ?>+</div>
                    <div class="text-cisa-muted font-medium uppercase text-xs tracking-wider">Published Articles</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold font-serif text-cisa-base mb-2">3-6 Days</div>
                    <div class="text-cisa-muted font-medium uppercase text-xs tracking-wider">Avg. Review Time</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold font-serif text-cisa-base mb-2">100%</div>
                    <div class="text-cisa-muted font-medium uppercase text-xs tracking-wider">Open Access</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Publish With Us Section -->
    <section id="why-publish" class="bg-slate-50 py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-serif font-bold text-cisa-base mb-6">Why Publish With CISA?</h2>
                <div class="w-24 h-1 bg-cisa-accent mx-auto"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div
                    class="bg-white p-8 rounded-xl shadow-glass border border-gray-100 hover:-translate-y-1 transition-transform duration-300">
                    <div
                        class="w-12 h-12 bg-cisa-base rounded-lg flex items-center justify-center text-cisa-accent text-xl mb-6">
                        <i class="fas fa-check-double"></i>
                    </div>
                    <h3 class="text-xl font-bold text-cisa-base mb-3">Rigorous Peer Review</h3>
                    <p class="text-gray-600 leading-relaxed text-sm">
                        All submissions undergo a thorough double-blind peer review process by independent experts in your
                        field, ensuring high-quality publications.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div
                    class="bg-white p-8 rounded-xl shadow-glass border border-gray-100 hover:-translate-y-1 transition-transform duration-300">
                    <div
                        class="w-12 h-12 bg-cisa-base rounded-lg flex items-center justify-center text-cisa-accent text-xl mb-6">
                        <i class="fas fa-globe"></i>
                    </div>
                    <h3 class="text-xl font-bold text-cisa-base mb-3">Global Reach</h3>
                    <p class="text-gray-600 leading-relaxed text-sm">
                        All published articles are freely accessible worldwide under Creative Commons licenses, maximizing
                        the visibility and impact of your research.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div
                    class="bg-white p-8 rounded-xl shadow-glass border border-gray-100 hover:-translate-y-1 transition-transform duration-300">
                    <div
                        class="w-12 h-12 bg-cisa-base rounded-lg flex items-center justify-center text-cisa-accent text-xl mb-6">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h3 class="text-xl font-bold text-cisa-base mb-3">Fast Publication</h3>
                    <p class="text-gray-600 leading-relaxed text-sm">
                        Our streamlined editorial process ensures rapid review and publication, with average review times of
                        3-6 weeks from submission.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div
                    class="bg-white p-8 rounded-xl shadow-glass border border-gray-100 hover:-translate-y-1 transition-transform duration-300">
                    <div
                        class="w-12 h-12 bg-cisa-base rounded-lg flex items-center justify-center text-cisa-accent text-xl mb-6">
                        <i class="fas fa-link"></i>
                    </div>
                    <h3 class="text-xl font-bold text-cisa-base mb-3">Indexing & Discovery</h3>
                    <p class="text-gray-600 leading-relaxed text-sm">
                        Our journals are indexed in major databases and search engines, ensuring your research is
                        discoverable by scholars worldwide.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div
                    class="bg-white p-8 rounded-xl shadow-glass border border-gray-100 hover:-translate-y-1 transition-transform duration-300">
                    <div
                        class="w-12 h-12 bg-cisa-base rounded-lg flex items-center justify-center text-cisa-accent text-xl mb-6">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="text-xl font-bold text-cisa-base mb-3">Expert Editorial Team</h3>
                    <p class="text-gray-600 leading-relaxed text-sm">
                        Work with experienced editors and reviewers who are leaders in their respective fields, providing
                        valuable feedback and guidance.
                    </p>
                </div>

                <!-- Feature 6 -->
                <div
                    class="bg-white p-8 rounded-xl shadow-glass border border-gray-100 hover:-translate-y-1 transition-transform duration-300">
                    <div
                        class="w-12 h-12 bg-cisa-base rounded-lg flex items-center justify-center text-cisa-accent text-xl mb-6">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="text-xl font-bold text-cisa-base mb-3">Impact & Visibility</h3>
                    <p class="text-gray-600 leading-relaxed text-sm">
                        Increase your research impact with our comprehensive promotion and marketing services, reaching a
                        global academic audience.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="bg-cisa-base text-white py-24 relative overflow-hidden">
        <div class="absolute inset-0 z-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-serif font-bold mb-6">Submission Process</h2>
                <p class="text-xl text-gray-400 max-w-3xl mx-auto font-light">
                    Our simple, streamlined submission process makes publishing your research easy and efficient.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 text-center">
                <div>
                    <div
                        class="w-16 h-16 bg-cisa-accent text-cisa-base rounded-full flex items-center justify-center mx-auto mb-6 text-2xl font-bold shadow-[0_0_20px_rgba(245,158,11,0.4)]">
                        1</div>
                    <h3 class="text-xl font-bold mb-4">Submit Manuscript</h3>
                    <p class="text-gray-400 leading-relaxed text-sm">
                        Create an account, choose your target journal, and submit your manuscript through our easy-to-use
                        online submission system.
                    </p>
                </div>

                <div>
                    <div
                        class="w-16 h-16 bg-cisa-accent text-cisa-base rounded-full flex items-center justify-center mx-auto mb-6 text-2xl font-bold shadow-[0_0_20px_rgba(245,158,11,0.4)]">
                        2</div>
                    <h3 class="text-xl font-bold mb-4">Peer Review</h3>
                    <p class="text-gray-400 leading-relaxed text-sm">
                        Your manuscript undergoes rigorous peer review by independent experts. You'll receive detailed
                        feedback to help improve your work.
                    </p>
                </div>

                <div>
                    <div
                        class="w-16 h-16 bg-cisa-accent text-cisa-base rounded-full flex items-center justify-center mx-auto mb-6 text-2xl font-bold shadow-[0_0_20px_rgba(245,158,11,0.4)]">
                        3</div>
                    <h3 class="text-xl font-bold mb-4">Publication</h3>
                    <p class="text-gray-400 leading-relaxed text-sm">
                        Once accepted, your article is published online and indexed in major databases, making it accessible
                        to researchers worldwide.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Journals List Wrapper (Reuse component if possible, or simple list) -->
    <section id="journals" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-serif font-bold text-cisa-base mb-6">Select a Journal to Submit</h2>
                <div class="w-24 h-1 bg-cisa-accent mx-auto"></div>
            </div>

            <?php if($journals->count() > 0): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php $__currentLoopData = $journals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $journal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div
                            class="group bg-white rounded-xl shadow-sm hover:shadow-xl border border-gray-100 transition-all duration-300 overflow-hidden">
                            <div class="h-40 bg-cisa-light relative flex items-center justify-center overflow-hidden">
                                <?php if($journal->cover_image): ?>
                                    <img src="<?php echo e(asset('storage/' . $journal->cover_image)); ?>" alt="<?php echo e($journal->name); ?>"
                                        class="w-full h-full object-cover opacity-60 group-hover:opacity-40 transition-opacity">
                                <?php else: ?>
                                    <i class="fas fa-book text-6xl text-white opacity-20"></i>
                                <?php endif; ?>
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                                <h3 class="absolute bottom-4 left-6 right-6 text-lg font-bold text-white font-serif leading-tight">
                                    <?php echo e(Str::limit($journal->name, 50)); ?>

                                </h3>
                            </div>
                            <div class="p-6">
                                <p class="text-gray-600 text-sm mb-6 line-clamp-3">
                                    <?php echo e(Str::limit($journal->description ?? 'Submission open for this journal.', 100)); ?>

                                </p>
                                <a href="<?php echo e(route('login')); ?>"
                                    class="block w-full bg-cisa-base text-white text-center py-3 rounded hover:bg-cisa-light transition-colors font-medium text-sm">
                                    Submit to this Journal
                                </a>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="text-center py-12">
                    <p class="text-gray-500">No journals available for submission at this time.</p>
                </div>
            <?php endif; ?>

            <div class="text-center mt-16">
                <a href="<?php echo e(route('journals.index')); ?>"
                    class="text-cisa-base font-semibold border-b-2 border-cisa-base hover:text-cisa-accent hover:border-cisa-accent transition-all pb-1">
                    Back to Home
                </a>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u857061584/domains/cisajournal.org/public_html/resources/views/publish/index.blade.php ENDPATH**/ ?>