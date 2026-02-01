<?php $__env->startSection('title', $journal->name . ' - Contact Us | CISA'); ?>

<?php $__env->startSection('content'); ?>
    <!-- Hero Section -->
    <div class="relative bg-cisa-base text-white overflow-hidden min-h-[350px] flex items-center">
        <!-- Dynamic Background Layer -->
        <div class="absolute inset-0 z-0">
            <?php if($journal->cover_image): ?>
                <div class="absolute inset-0 bg-cover bg-center blur-3xl opacity-30 transform scale-110"
                    style="background-image: url('<?php echo e(asset('storage/' . $journal->cover_image)); ?>');">
                </div>
            <?php endif; ?>
            <div class="absolute inset-0 bg-gradient-to-r from-cisa-base via-cisa-base/90 to-transparent"></div>
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10">
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full py-16">
            <nav class="flex mb-6 text-sm text-gray-300" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-2">
                    <li><a href="<?php echo e(route('journals.index')); ?>" class="hover:text-cisa-accent transition-colors">Home</a>
                    </li>
                    <li><i class="fas fa-chevron-right text-xs opacity-50"></i></li>
                    <li><a href="<?php echo e(route('journals.show', $journal)); ?>"
                            class="hover:text-cisa-accent transition-colors"><?php echo e($journal->name); ?></a></li>
                    <li><i class="fas fa-chevron-right text-xs opacity-50"></i></li>
                    <li class="text-white font-semibold">Contact Us</li>
                </ol>
            </nav>

            <div class="max-w-4xl">
                <h1 class="text-3xl md:text-5xl font-serif font-bold leading-tight mb-4 text-white text-shadow-sm">
                    Get in Touch
                </h1>
                <p class="text-blue-100 text-lg font-light max-w-2xl">
                    We're here to help with any questions regarding submission, review, or publication.
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content Layout -->
    <div class="bg-slate-50 py-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

                <!-- Contact Information -->
                <div class="space-y-8">
                    <div>
                        <span class="text-cisa-accent font-bold uppercase tracking-wider text-sm mb-2 block">Contact
                            Details</span>
                        <h2 class="text-3xl font-serif font-bold text-cisa-base mb-6">How can we help you?</h2>
                        <p class="text-gray-600 leading-relaxed mb-8">
                            Whether you have questions about the submission process, technical support, or editorial
                            policies, our team is ready to assist you.
                        </p>
                    </div>

                    <div class="grid gap-6">
                        <?php if($journal->primary_contact_email): ?>
                            <div
                                class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm flex items-start gap-4 hover:shadow-md transition-shadow">
                                <div
                                    class="w-12 h-12 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-envelope text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-cisa-base mb-1">Email Us</h3>
                                    <?php if($journal->primary_contact_name): ?>
                                        <p class="text-sm text-cisa-base font-bold mb-1"><?php echo e($journal->primary_contact_name); ?></p>
                                    <?php endif; ?>
                                    <p class="text-sm text-gray-500 mb-2">Primary Contact for queries</p>
                                    <a href="mailto:<?php echo e($journal->primary_contact_email); ?>"
                                        class="text-cisa-accent font-bold hover:text-cisa-base transition-colors">
                                        <?php echo e($journal->primary_contact_email); ?>

                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if($journal->contact_phone): ?>
                            <div
                                class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm flex items-start gap-4 hover:shadow-md transition-shadow">
                                <div
                                    class="w-12 h-12 bg-green-50 text-green-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-phone text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-cisa-base mb-1">Call Us</h3>
                                    <p class="text-sm text-gray-500 mb-2">Mon-Fri from 9am to 5pm</p>
                                    <a href="tel:<?php echo e($journal->contact_phone); ?>"
                                        class="text-cisa-accent font-bold hover:text-cisa-base transition-colors">
                                        <?php echo e($journal->contact_phone); ?>

                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if($journal->contact_address): ?>
                            <div
                                class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm flex items-start gap-4 hover:shadow-md transition-shadow">
                                <div
                                    class="w-12 h-12 bg-purple-50 text-purple-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-map-marker-alt text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-cisa-base mb-1">Visit Us</h3>
                                    <p class="text-gray-600 text-sm whitespace-pre-line leading-relaxed">
                                        <?php echo e($journal->contact_address); ?>

                                    </p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="bg-white rounded-xl shadow-glass border border-gray-100 p-8 md:p-10 relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 -mt-20 -mr-20 w-64 h-64 bg-cisa-accent rounded-full opacity-5 blur-3xl pointer-events-none">
                    </div>

                    <h3 class="text-2xl font-serif font-bold text-cisa-base mb-6 relative z-10">Send a Message</h3>

                    <form action="#" method="POST" class="space-y-5 relative z-10">
                        <?php echo csrf_field(); ?>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Name</label>
                                <input type="text" id="name" name="name" required
                                    class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:outline-none focus:bg-white focus:border-cisa-accent transition-all"
                                    placeholder="John Doe">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                                <input type="email" id="email" name="email" required
                                    class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:outline-none focus:bg-white focus:border-cisa-accent transition-all"
                                    placeholder="john@example.com">
                            </div>
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-bold text-gray-700 mb-2">Subject</label>
                            <input type="text" id="subject" name="subject" required
                                class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:outline-none focus:bg-white focus:border-cisa-accent transition-all"
                                placeholder="How can we help you?">
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-bold text-gray-700 mb-2">Message</label>
                            <textarea id="message" name="message" rows="5" required
                                class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:outline-none focus:bg-white focus:border-cisa-accent transition-all resize-none"
                                placeholder="Your message here..."></textarea>
                        </div>

                        <button type="submit"
                            class="btn-cisa-primary w-full py-4 text-lg shadow-lg hover:-translate-y-1 transition-transform">
                            Send Message <i class="fas fa-paper-plane ml-2"></i>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u857061584/domains/cisajournal.org/public_html/resources/views/journals/contact.blade.php ENDPATH**/ ?>