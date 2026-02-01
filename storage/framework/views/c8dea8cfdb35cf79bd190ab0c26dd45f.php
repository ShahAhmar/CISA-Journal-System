

<?php $__env->startSection('title', 'Partnerships - ' . $journal->name); ?>

<?php $__env->startSection('content'); ?>
    <!-- Hero Section -->
    <div class="bg-cisa-base text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-serif font-bold mb-4">Partnerships</h1>
            <p class="text-xl text-gray-300 max-w-3xl">
                Collaborating with institutions to advance African research.
            </p>
        </div>
    </div>

    <!-- Content Section -->
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="max-w-4xl mx-auto space-y-12">

                <?php if($journal->partnerships_content): ?>
                    <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed bg-white rounded-3xl p-8 md:p-12 border border-slate-50 shadow-sm">
                        <?php echo $journal->partnerships_content; ?>

                    </div>
                <?php endif; ?>

                <?php if($journal->partners->count() > 0): ?>
                    <!-- Institutional Partners -->
                    <section class="text-center">
                        <h2 class="text-2xl font-serif font-bold text-cisa-base mb-10">Our Strategic Partners</h2>
                        
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                            <?php $__currentLoopData = $journal->partners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $partner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm flex flex-col items-center justify-center hover:shadow-xl hover:-translate-y-1 transition-all group relative overflow-hidden">
                                    <div class="absolute inset-0 bg-gradient-to-br from-cisa-accent/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                    
                                    <?php if($partner->website_url): ?>
                                        <a href="<?php echo e($partner->website_url); ?>" target="_blank" class="flex flex-col items-center">
                                    <?php endif; ?>
                                    
                                    <img src="<?php echo e(asset('storage/' . $partner->logo)); ?>" alt="<?php echo e($partner->name); ?>" class="h-20 w-auto object-contain mb-4 filter grayscale group-hover:grayscale-0 transition-all duration-500">
                                    
                                    <?php if($partner->name): ?>
                                        <span class="text-xs font-bold text-gray-500 uppercase tracking-widest text-center"><?php echo e($partner->name); ?></span>
                                    <?php endif; ?>

                                    <?php if($partner->website_url): ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </section>
                <?php endif; ?>

                <?php if(!$journal->partnerships_content && $journal->partners->count() == 0): ?>
                    <!-- Default Institutional Partners (Placeholder behavior) -->
                    <section class="text-center">
                        <h2 class="text-2xl font-serif font-bold text-cisa-base mb-6">Our Partners</h2>
                        <p class="text-gray-600 mb-8 max-w-2xl mx-auto">
                            We work with universities, research councils, and libraries to ensure sustainable scholarly
                            publishing.
                        </p>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 opacity-40">
                            <?php for($i = 0; $i < 4; $i++): ?>
                                <div class="h-32 bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl flex items-center justify-center font-bold text-slate-300 italic">
                                    Partner Logo
                                </div>
                            <?php endfor; ?>
                        </div>
                    </section>

                    <!-- Collaborative Projects -->
                    <section>
                        <h2 class="text-2xl font-serif font-bold text-cisa-base mb-6 flex items-center">
                            <span class="w-1.5 h-8 bg-cisa-accent mr-4 rounded-full"></span>
                            Collaborative Projects
                        </h2>
                        <div class="bg-slate-50 border border-gray-100 rounded-3xl p-10 group hover:bg-white hover:shadow-xl transition-all">
                            <h3 class="font-bold text-xl text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-lightbulb text-cisa-accent mr-3"></i>
                                Capacity Building Workshops
                            </h3>
                            <p class="text-gray-600 leading-relaxed">
                                Training early-career researchers in academic writing and publishing ethics across the African continent. Our goal is to empower the next generation of scholars with global standards.
                            </p>
                        </div>
                    </section>
                <?php endif; ?>

                <!-- Become a Partner -->
                <section
                    class="bg-cisa-base text-white rounded-xl p-8 md:p-12 text-center shadow-lg relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-32 h-32 bg-cisa-accent opacity-10 rounded-full transform translate-x-1/2 -translate-y-1/2">
                    </div>
                    <div
                        class="absolute bottom-0 left-0 w-24 h-24 bg-cisa-accent opacity-10 rounded-full transform -translate-x-1/2 translate-y-1/2">
                    </div>

                    <h2 class="text-3xl font-serif font-bold mb-4">Support Our Mission</h2>
                    <p class="text-gray-300 mb-8 max-w-2xl mx-auto">
                        Help us sustain open-access publishing and support researchers across the continent. Your
                        contribution directly funds platform maintenance and waiver programs.
                    </p>

                    <!-- DONATION BUTTON (Strictly Approved Wording) -->
                    <a href="#"
                        class="inline-block bg-cisa-accent text-cisa-base font-bold text-lg py-4 px-8 rounded-full shadow-md hover:bg-white hover:scale-105 transition-all transform">
                        Support African Research and Knowledge Dissemination
                    </a>

                    <p class="mt-6 text-xs text-gray-400">
                        CIJ is a non-profit initiative.
                    </p>
                </section>

            </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u857061584/domains/cisajournal.org/public_html/resources/views/journals/partnerships.blade.php ENDPATH**/ ?>