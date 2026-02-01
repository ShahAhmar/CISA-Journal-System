

<?php $__env->startSection('title', 'Publications - Master List - ' . $journal->name); ?>

<?php $__env->startSection('content'); ?>
    <!-- Hero Section -->
    <div class="bg-cisa-base text-white py-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10">
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h1 class="text-5xl md:text-6xl font-serif font-bold mb-6">Research Repository</h1>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto leading-relaxed">
                Explore our full catalog of interdisciplinary peer-reviewed research.
            </p>
        </div>
    </div>

    <!-- Search & Filter Bar -->
    <div
        class="bg-white border-b border-gray-100 py-10 sticky top-[72px] z-40 shadow-xl shadow-slate-200/50 backdrop-blur-md bg-white/90">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <form action="<?php echo e(route('journals.publications', $journal)); ?>" method="GET"
                class="grid grid-cols-1 md:grid-cols-12 gap-6 items-end">

                <!-- Search -->
                <div class="md:col-span-5">
                    <label class="block text-[10px] font-bold text-cisa-muted uppercase tracking-widest mb-2">Search
                        Catalog</label>
                    <div class="relative group">
                        <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                            placeholder="Keywords, Titles, Authors..."
                            class="w-full pl-12 pr-4 py-4 rounded-2xl border-2 border-slate-100 focus:border-cisa-accent focus:ring-0 transition-all bg-slate-50 group-hover:bg-white">
                        <i
                            class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-cisa-accent"></i>
                    </div>
                </div>

                <!-- Year -->
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-bold text-cisa-muted uppercase tracking-widest mb-2">Year</label>
                    <select name="year"
                        class="w-full py-4 pl-4 pr-10 rounded-2xl border-2 border-slate-100 bg-slate-50 focus:border-cisa-accent focus:ring-0 transition-all cursor-pointer">
                        <option value="">All Time</option>
                        <?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($year); ?>" <?php echo e(request('year') == $year ? 'selected' : ''); ?>><?php echo e($year); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <!-- Discipline -->
                <div class="md:col-span-3">
                    <label
                        class="block text-[10px] font-bold text-cisa-muted uppercase tracking-widest mb-2">Discipline</label>
                    <select name="discipline"
                        class="w-full py-4 pl-4 pr-10 rounded-2xl border-2 border-slate-100 bg-slate-50 focus:border-cisa-accent focus:ring-0 transition-all cursor-pointer">
                        <option value="">All Disciplines</option>
                        <?php $__currentLoopData = $disciplines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($d->name); ?>" <?php echo e(request('discipline') == $d->name ? 'selected' : ''); ?>>
                                <?php echo e($d->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <!-- Action -->
                <div class="md:col-span-2">
                    <button type="submit"
                        class="w-full h-[60px] bg-cisa-base text-white font-bold rounded-2xl hover:bg-cisa-accent hover:text-cisa-base transition-all shadow-lg shadow-cisa-base/10 flex items-center justify-center gap-2">
                        <i class="fas fa-sliders-h text-xs"></i> Apply
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Section -->
    <div class="py-20 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex flex-wrap items-center justify-between mb-12 gap-4">
                <h2 class="text-2xl font-serif font-bold text-cisa-base">
                    <?php if(request('search') || request('year') || request('discipline')): ?>
                        Search Results <span class="text-cisa-accent text-sm ml-2">(<?php echo e($publications->total()); ?> items)</span>
                    <?php else: ?>
                        Recent Publications
                    <?php endif; ?>
                </h2>

                <!-- Sort -->
                <div class="flex items-center gap-3">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Sort:</span>
                    <a href="<?php echo e(request()->fullUrlWithQuery(['sort' => 'newest'])); ?>"
                        class="text-xs font-bold <?php echo e(request('sort', 'newest') == 'newest' ? 'text-cisa-base border-b-2 border-cisa-accent' : 'text-slate-400 hover:text-cisa-base'); ?> py-1">Newest</a>
                    <a href="<?php echo e(request()->fullUrlWithQuery(['sort' => 'oldest'])); ?>"
                        class="text-xs font-bold <?php echo e(request('sort') == 'oldest' ? 'text-cisa-base border-b-2 border-cisa-accent' : 'text-slate-400 hover:text-cisa-base'); ?> py-1 ml-4">Oldest</a>
                </div>
            </div>

            <?php if($publications->count() > 0): ?>
                <div class="grid grid-cols-1 gap-8">
                    <?php $__currentLoopData = $publications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <article
                            class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm hover:shadow-2xl hover:-translate-y-1 transition-all group overflow-hidden relative">
                            <div
                                class="absolute top-0 left-0 w-1.5 h-full bg-slate-100 group-hover:bg-cisa-accent transition-colors">
                            </div>

                            <div class="flex flex-col lg:flex-row gap-10">
                                <!-- Info -->
                                <div class="flex-grow space-y-4">
                                    <div class="flex flex-wrap items-center gap-4">
                                        <span
                                            class="bg-cisa-accent/10 text-cisa-base text-[10px] px-3 py-1 rounded-full font-bold uppercase tracking-widest border border-cisa-accent/20">
                                            <?php echo e($submission->discipline ?? 'Interdisciplinary'); ?>

                                        </span>
                                        <span class="text-slate-400 text-xs font-medium flex items-center">
                                            <i class="far fa-calendar-alt mr-2 text-cisa-accent"></i>
                                            <?php echo e($submission->published_at ? \Carbon\Carbon::parse($submission->published_at)->format('F d, Y') : 'Pending Publication'); ?>

                                        </span>
                                        <?php if($submission->doi): ?>
                                            <span class="text-slate-300 text-xs font-mono">DOI: <?php echo e($submission->doi); ?></span>
                                        <?php endif; ?>
                                    </div>

                                    <h3
                                        class="text-2xl md:text-3xl font-serif font-bold text-cisa-base leading-tight group-hover:text-cisa-accent transition-colors">
                                        <a
                                            href="<?php echo e(route('journals.article', ['journal' => $journal->slug, 'submission' => $submission->id])); ?>">
                                            <?php echo e($submission->title); ?>

                                        </a>
                                    </h3>

                                    <div class="flex flex-wrap gap-x-6 gap-y-2">
                                        <?php $__currentLoopData = $submission->authors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $author): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="text-cisa-muted font-bold text-sm flex items-center">
                                                <i class="fas fa-user-circle mr-2 text-slate-300"></i>
                                                <?php echo e($author->full_name); ?>

                                            </span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>

                                    <p class="text-slate-500 text-sm leading-relaxed line-clamp-3 italic">
                                        <?php echo e(Str::limit(strip_tags($submission->abstract), 300)); ?>

                                    </p>
                                </div>

                                <!-- Actions -->
                                <div
                                    class="lg:w-64 shrink-0 flex flex-col gap-4 justify-center border-t lg:border-t-0 lg:border-l border-slate-50 pt-8 lg:pt-0 lg:pl-10">
                                    <a href="<?php echo e(route('journals.article', ['journal' => $journal->slug, 'submission' => $submission->id])); ?>"
                                        class="w-full h-12 flex items-center justify-center bg-slate-100 text-cisa-base font-bold rounded-xl hover:bg-cisa-base hover:text-white transition-all text-sm group/btn">
                                        Read Article <i
                                            class="fas fa-arrow-right ml-2 text-xs opacity-0 group-hover/btn:opacity-100 group-hover/btn:translate-x-1 transition-all"></i>
                                    </a>
                                    <a href="<?php echo e(route('journals.article.download', ['journal' => $journal->slug, 'submission' => $submission->id])); ?>"
                                        class="w-full h-12 flex items-center justify-center border-2 border-slate-100 text-cisa-muted font-bold rounded-xl hover:border-cisa-accent hover:text-cisa-base transition-all text-sm gap-2">
                                        <i class="fas fa-file-pdf text-red-500"></i> Download PDF
                                    </a>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <!-- Pagination -->
                <div class="mt-20">
                    <?php echo e($publications->appends(request()->query())->links('vendor.pagination.tailwind')); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-40 bg-white rounded-3xl border-2 border-dashed border-slate-100 shadow-sm">
                    <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-8">
                        <i class="fas fa-search text-4xl text-slate-200"></i>
                    </div>
                    <h3 class="text-2xl font-serif font-bold text-slate-400">No matching research found</h3>
                    <p class="text-slate-400 mt-4 max-w-sm mx-auto">Try broadening your search criteria or explore our newest
                        releases.</p>
                    <a href="<?php echo e(route('journals.publications', $journal)); ?>"
                        class="mt-8 inline-block text-cisa-accent font-bold hover:underline">Clear all filters</a>
                </div>
            <?php endif; ?>

            <!-- Bottom CTA -->
            <div class="mt-32 bg-cisa-base rounded-[3rem] p-16 text-center shadow-2xl relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-cisa-base to-cisa-light opacity-50"></div>
                <div class="relative z-10 max-w-3xl mx-auto">
                    <h2 class="text-4xl md:text-5xl font-serif font-bold text-white mb-8">Contribute to the Archive</h2>
                    <p class="text-gray-300 text-lg mb-12">Submit your manuscript for the next quarterly issue of the CISA
                        Interdisciplinary Journal.</p>
                    <div class="flex flex-wrap justify-center gap-6">
                        <a href="<?php echo e(route('author.submissions.create', $journal)); ?>"
                            class="px-12 py-5 bg-cisa-accent text-cisa-base font-bold rounded-full hover:bg-white transition-all shadow-xl shadow-cisa-accent/10 uppercase tracking-widest text-sm">
                            Submit Your Manuscript
                        </a>
                        <a href="<?php echo e(route('journals.about', $journal)); ?>"
                            class="px-12 py-5 bg-white/10 text-white border border-white/20 font-bold rounded-full hover:bg-white/20 transition-all uppercase tracking-widest text-sm">
                            Author Guidelines
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u857061584/domains/cisajournal.org/public_html/resources/views/journals/publications.blade.php ENDPATH**/ ?>