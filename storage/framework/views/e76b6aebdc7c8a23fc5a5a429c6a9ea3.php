

<?php $__env->startSection('title', 'About CIJ - ' . $journal->name); ?>

<?php $__env->startSection('content'); ?>
    <div class="bg-cisa-base text-white py-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10">
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <h1 class="text-5xl md:text-6xl font-serif font-bold mb-6">About CIJ</h1>
            <p class="text-xl text-gray-300 max-w-3xl leading-relaxed">
                An independent scholarly publishing initiative committed to ethical research dissemination, editorial
                integrity, and interdisciplinary collaboration.
            </p>
        </div>
    </div>

    <!-- Content Section -->
    <div class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-16">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-16">

                    <!-- Overview -->
                    <section id="overview">
                        <h2 class="text-3xl font-serif font-bold text-cisa-base mb-8 flex items-center">
                            <span class="w-1.5 h-8 bg-cisa-accent mr-4 rounded-full"></span>
                            Journal Overview
                        </h2>
                        <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed font-sans">
                            <?php echo $journal->description; ?>

                        </div>
                    </section>

                    <!-- Vision & Mission -->
                    <?php if($journal->vision || $journal->mission): ?>
                        <section id="vision-mission" class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <?php if($journal->vision): ?>
                                <div class="bg-slate-50 p-10 rounded-3xl border border-slate-100 relative group overflow-hidden">
                                    <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                                        <i class="fas fa-eye text-6xl"></i>
                                    </div>
                                    <h3 class="text-2xl font-serif font-bold text-cisa-base mb-4">Vision</h3>
                                    <div class="text-gray-600 leading-relaxed">
                                        <?php echo $journal->vision; ?>

                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if($journal->mission): ?>
                                <div class="bg-slate-50 p-10 rounded-3xl border border-slate-100 relative group overflow-hidden">
                                    <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                                        <i class="fas fa-bullseye text-6xl"></i>
                                    </div>
                                    <h3 class="text-2xl font-serif font-bold text-cisa-base mb-4">Mission</h3>
                                    <div class="text-gray-600 leading-relaxed">
                                        <?php echo $journal->mission; ?>

                                    </div>
                                </div>
                            <?php endif; ?>
                        </section>
                    <?php endif; ?>

                    <!-- Aims & Scope -->
                    <?php if($journal->aims_scope): ?>
                        <section id="aims-scope">
                            <div class="bg-white rounded-3xl p-10 border-2 border-slate-50 shadow-sm">
                                <h2 class="text-3xl font-serif font-bold text-cisa-base mb-8 flex items-center">
                                    <span class="w-1.5 h-8 bg-cisa-accent mr-4 rounded-full"></span>
                                    Aims & Scope
                                </h2>
                                <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                                    <?php echo $journal->aims_scope; ?>

                                </div>
                            </div>
                        </section>
                    <?php endif; ?>

                    <!-- Publication Details -->
                    <?php if($journal->publication_frequency): ?>
                        <section id="details" class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="p-8 border border-gray-100 rounded-3xl">
                                <h4 class="text-xs font-bold text-cisa-accent uppercase tracking-widest mb-4">Frequency</h4>
                                <h3 class="text-xl font-bold text-cisa-base mb-2">Publishing Frequency</h3>
                                <div class="text-gray-600 text-sm">
                                    <?php echo $journal->publication_frequency; ?>

                                </div>
                            </div>
                            <div class="p-8 border border-gray-100 rounded-3xl">
                                <h4 class="text-xs font-bold text-cisa-accent uppercase tracking-widest mb-4">Publisher</h4>
                                <h3 class="text-xl font-bold text-cisa-base mb-2">Publisher Information</h3>
                                <p class="text-gray-600 text-sm">
                                    Published by CISA Scholarly Publishing Initiative.
                                </p>
                            </div>
                        </section>
                    <?php endif; ?>

                </div>

                <!-- Sidebar / Essential Info -->
                <div class="lg:col-span-1">
                    <div class="sticky top-24 space-y-8">
                        <!-- ISSN Card -->
                        <?php if($journal->online_issn): ?>
                            <div class="bg-slate-900 text-white p-8 rounded-3xl shadow-2xl relative overflow-hidden">
                                <div
                                    class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-cisa-accent rounded-full opacity-10 blur-2xl">
                                </div>
                                <h3 class="text-sm font-bold text-cisa-accent uppercase tracking-widest mb-6">Journal Identity
                                </h3>
                                <div class="space-y-4">
                                    <div>
                                        <span class="text-gray-400 text-xs block mb-1">Online ISSN</span>
                                        <span class="text-xl font-mono font-bold"><?php echo e($journal->online_issn); ?></span>
                                    </div>
                                    <div class="pt-4 border-t border-white/10">
                                        <span class="text-gray-400 text-xs block mb-1">Status</span>
                                        <span class="text-sm font-bold flex items-center">
                                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span> Active & Indexed
                                        </span>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- CTA Box -->
                        <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-xl space-y-6">
                            <h3 class="text-2xl font-serif font-bold text-cisa-base">Ready to Submit?</h3>
                            <p class="text-gray-500 text-sm leading-relaxed">
                                Join our global community of scholars. We welcome original interdisciplinary contributions.
                            </p>
                            <a href="<?php echo e(route('author.submissions.create', $journal)); ?>"
                                class="w-full block text-center bg-cisa-base text-white font-bold py-4 rounded-full hover:bg-cisa-accent hover:text-cisa-base transition-all shadow-lg shadow-cisa-base/20">
                                Submit Your Manuscript
                            </a>
                            <a href="<?php echo e(route('journals.contact', $journal)); ?>"
                                class="w-full block text-center border-2 border-slate-100 text-gray-600 font-bold py-4 rounded-full hover:border-cisa-base hover:text-cisa-base transition-all">
                                Contact Editorial Office
                            </a>
                        </div>

                        <!-- Secondary Links -->
                        <div class="grid grid-cols-1 gap-4">
                            <a href="<?php echo e(route('journals.info', $journal)); ?>"
                                class="flex items-center p-4 bg-slate-50 rounded-2xl hover:bg-slate-100 transition-colors group">
                                <div
                                    class="w-10 h-10 bg-white rounded-xl flex items-center justify-center mr-4 shadow-sm group-hover:bg-cisa-base group-hover:text-white transition-colors">
                                    <i class="fas fa-fingerprint"></i>
                                </div>
                                <span class="font-bold text-sm text-gray-700">Journal Identity</span>
                            </a>
                            <a href="<?php echo e(route('journals.editorial-ethics', $journal)); ?>"
                                class="flex items-center p-4 bg-slate-50 rounded-2xl hover:bg-slate-100 transition-colors group">
                                <div
                                    class="w-10 h-10 bg-white rounded-xl flex items-center justify-center mr-4 shadow-sm group-hover:bg-cisa-base group-hover:text-white transition-colors">
                                    <i class="fas fa-balance-scale"></i>
                                </div>
                                <span class="font-bold text-sm text-gray-700">Ethics & Board</span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u857061584/domains/cisajournal.org/public_html/resources/views/journals/about.blade.php ENDPATH**/ ?>