

<?php $__env->startSection('title', 'Call for Papers - ' . $journal->name); ?>

<?php $__env->startSection('content'); ?>
    <!-- Hero Section -->
    <div class="bg-cisa-base text-white py-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10">
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <h1 class="text-5xl md:text-6xl font-serif font-bold mb-6">Call for Papers</h1>
            <p class="text-xl text-gray-300 max-w-3xl leading-relaxed">
                Open invitations for original, unpublished interdisciplinary research. Join our next quarterly issue.
            </p>
        </div>
    </div>

    <!-- Content Section -->
    <div class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
                <!-- Main Content -->
                <div class="lg:col-span-8 space-y-16">

                    <!-- Active Call -->
                    <section id="active-call" class="relative">
                        <div
                            class="absolute -top-4 -left-4 w-24 h-24 bg-cisa-accent rounded-full opacity-10 blur-3xl animate-pulse">
                        </div>
                        <div
                            class="bg-white rounded-[2rem] border-2 border-slate-50 p-10 shadow-sm relative overflow-hidden group hover:border-cisa-accent/20 transition-all">
                            <div class="flex items-center gap-3 mb-8">
                                <span
                                    class="px-4 py-1.5 bg-green-500 text-white text-[10px] font-bold uppercase tracking-widest rounded-full shadow-lg shadow-green-200">Open
                                    Now</span>
                                <span class="text-slate-300">/</span>
                                <span class="text-slate-400 text-xs font-bold uppercase tracking-widest">General
                                    Submission</span>
                            </div>

                            <?php if($journal->call_for_papers): ?>
                                <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed font-sans">
                                    <?php echo $journal->call_for_papers; ?>

                                </div>
                            <?php else: ?>
                                <h2 class="text-4xl font-serif font-bold text-cisa-base mb-6">Multidisciplinary Research
                                    Invitation</h2>
                                <p class="text-gray-600 text-lg leading-relaxed mb-8">
                                    CISA Interdisciplinary Journal (CIJ) accepts submissions on a continuous rolling basis. We
                                    invite original research articles, case studies, and theoretical papers that contribute
                                    significantly to academic knowledge and practical innovation within the context of African
                                    development and global progress.
                                </p>

                                <div class="grid md:grid-cols-2 gap-10 mb-10">
                                    <div
                                        class="p-6 bg-slate-50 rounded-2xl border border-slate-100 group-hover:bg-white transition-colors">
                                        <div class="text-cisa-accent mb-4"><i class="fas fa-clock text-2xl"></i></div>
                                        <h4 class="font-bold text-cisa-base mb-2">Submission Timeline</h4>
                                        <p class="text-sm text-gray-500">Submissions are reviewed quarterly. Current cycle
                                            deadline: 15th of next month.</p>
                                    </div>
                                    <div
                                        class="p-6 bg-slate-50 rounded-2xl border border-slate-100 group-hover:bg-white transition-colors">
                                        <div class="text-cisa-accent mb-4"><i class="fas fa-search-plus text-2xl"></i></div>
                                        <h4 class="font-bold text-cisa-base mb-2">Peer Review Speed</h4>
                                        <p class="text-sm text-gray-500">First decision within 30-45 days. Publication within
                                            60-90 days of acceptance.</p>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="pt-8 border-t border-slate-50">
                                <a href="<?php echo e(route('author.submissions.create', $journal)); ?>"
                                    class="inline-flex items-center px-10 py-4 bg-cisa-base text-white font-bold rounded-full hover:bg-cisa-accent hover:text-cisa-base transition-all shadow-xl shadow-cisa-base/10">
                                    Submit Your Manuscript <i class="fas fa-arrow-right ml-3 text-xs"></i>
                                </a>
                            </div>
                        </div>
                    </section>

                    <!-- Special Issues Hint -->
                    <section id="special-issues" class="bg-slate-50 rounded-3xl p-12 border border-slate-100 text-center">
                        <div class="max-w-xl mx-auto">
                            <h3 class="text-2xl font-serif font-bold text-cisa-base mb-4">Suggest a Special Issue</h3>
                            <p class="text-gray-500 leading-relaxed mb-8">We welcome proposals for themed special issues
                                that address emerging global challenges. Lead the conversation as a Guest Editor.</p>
                            <a href="<?php echo e(route('journals.contact', $journal)); ?>"
                                class="font-bold text-cisa-accent hover:underline flex items-center justify-center gap-2">
                                Contact Editorial Office <i class="fas fa-envelope text-xs"></i>
                            </a>
                        </div>
                    </section>
                </div>

                <!-- Sidebar / CTAs -->
                <div class="lg:col-span-4">
                    <div class="sticky top-24 space-y-8">
                        <!-- Submission Highlights -->
                        <div class="bg-cisa-base text-white p-10 rounded-3xl shadow-2xl relative overflow-hidden">
                            <div class="absolute bottom-0 right-0 p-4 opacity-10">
                                <i class="fas fa-paper-plane text-6xl text-cisa-accent rotate-12"></i>
                            </div>
                            <h3 class="text-xl font-bold mb-6 border-b border-white/10 pb-4">Author Checklist</h3>
                            <ul class="space-y-4">
                                <li class="flex items-start gap-3">
                                    <i class="fas fa-check text-cisa-accent mt-1"></i>
                                    <span class="text-sm text-gray-300">Original, unpublished work with < 15% similarity
                                            index.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <i class="fas fa-check text-cisa-accent mt-1"></i>
                                    <span class="text-sm text-gray-300">Structured as per CISA formatting standards.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <i class="fas fa-check text-cisa-accent mt-1"></i>
                                    <span class="text-sm text-gray-300">All author metadata and ORCIDs available.</span>
                                </li>
                            </ul>
                            <div class="mt-8">
                                <a href="<?php echo e(route('journals.about', $journal)); ?>#guidelines"
                                    class="text-xs font-black uppercase tracking-widest text-white/50 hover:text-white transition-colors">
                                    View Full Guidelines &rarr;
                                </a>
                            </div>
                        </div>

                        <!-- FAQ CTA -->
                        <div class="bg-white p-10 rounded-3xl border border-slate-100 shadow-sm text-center">
                            <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-question-circle text-cisa-base text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-cisa-base mb-2">Have Questions?</h3>
                            <p class="text-gray-500 text-sm mb-8">Check our APC details or contact support for help with
                                your submission.</p>
                            <div class="flex flex-col gap-3">
                                <a href="<?php echo e(route('journals.apc-submission', $journal)); ?>"
                                    class="w-full py-3 bg-slate-100 text-cisa-base font-bold rounded-xl hover:bg-slate-200 transition-all text-xs">
                                    View APC Details
                                </a>
                                <a href="<?php echo e(route('journals.contact', $journal)); ?>"
                                    class="w-full py-3 border-2 border-slate-50 text-slate-400 font-bold rounded-xl hover:border-cisa-accent hover:text-cisa-base transition-all text-xs">
                                    Talk to Support
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u857061584/domains/cisajournal.org/public_html/resources/views/journals/call-for-papers.blade.php ENDPATH**/ ?>