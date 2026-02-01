<?php $__env->startSection('title', 'Login - CISA Interdisciplinary Journal'); ?>

<?php $__env->startSection('content'); ?>
    <div
        class="min-h-screen flex items-center justify-center bg-slate-50 py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Background Patterns -->
        <div class="fixed inset-0 pointer-events-none opacity-5">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
        </div>

        <div class="max-w-md w-full relative z-10">
            <!-- Logo & Header -->
            <div class="text-center mb-8">
                <a href="<?php echo e(route('journals.index')); ?>" class="inline-block mb-6 group">
                    <div
                        class="w-20 h-20 bg-cisa-base rounded-2xl flex items-center justify-center shadow-xl transform group-hover:scale-105 transition-transform duration-300 mx-auto border-2 border-cisa-accent">
                        <span class="font-serif font-bold text-4xl text-cisa-accent">C</span>
                    </div>
                </a>
                <h1 class="text-3xl font-bold font-serif text-cisa-base mb-2">
                    Welcome Back
                </h1>
                <p class="text-cisa-muted">Sign in to access your dashboard</p>
            </div>

            <!-- Error Messages -->
            <?php if($errors->any()): ?>
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-500 mt-1"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-bold text-red-800">Authentication Error</h3>
                            <ul class="list-disc list-inside text-sm text-red-700 mt-1">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if(session('success')): ?>
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        <span class="text-sm font-bold text-green-800"><?php echo e(session('success')); ?></span>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <div class="bg-white rounded-xl shadow-glass border border-gray-100 p-8 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-cisa-base via-cisa-accent to-cisa-base">
                </div>

                <form class="space-y-6" method="POST" action="<?php echo e(route('login')); ?>"
                    x-data="{ showPassword: false, loading: false }" @submit="loading = true">
                    <?php echo csrf_field(); ?>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-bold text-cisa-base mb-2">
                            Email Address
                        </label>
                        <div class="relative group">
                            <input id="email" name="email" type="email" autocomplete="email" required
                                class="w-full px-4 py-3 pl-10 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-cisa-accent/50 focus:border-cisa-accent transition-all duration-300 bg-slate-50 focus:bg-white text-cisa-base"
                                placeholder="name@institution.edu" value="<?php echo e(old('email')); ?>" @input="loading = false">
                            <i
                                class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-cisa-accent transition-colors"></i>
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="password" class="block text-sm font-bold text-cisa-base">
                                Password
                            </label>
                        </div>
                        <div class="relative group">
                            <input id="password" name="password" :type="showPassword ? 'text' : 'password'"
                                autocomplete="current-password" required
                                class="w-full px-4 py-3 pl-10 pr-10 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-cisa-accent/50 focus:border-cisa-accent transition-all duration-300 bg-slate-50 focus:bg-white text-cisa-base"
                                placeholder="Enter your password">
                            <i
                                class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-cisa-accent transition-colors"></i>
                            <button type="button" @click="showPassword = !showPassword"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-cisa-base transition-colors focus:outline-none">
                                <i class="fas" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember & Forgot -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember" name="remember" type="checkbox"
                                class="h-4 w-4 text-cisa-accent focus:ring-cisa-accent border-gray-300 rounded cursor-pointer">
                            <label for="remember" class="ml-2 block text-sm text-gray-600 cursor-pointer select-none">
                                Remember me
                            </label>
                        </div>
                        <a href="<?php echo e(route('password.request')); ?>"
                            class="text-sm font-semibold text-cisa-accent hover:text-cisa-base transition-colors">
                            Forgot password?
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit"
                            class="w-full bg-cisa-base text-white font-bold py-3.5 px-6 rounded-lg shadow-lg hover:shadow-xl hover:bg-slate-800 transform hover:-translate-y-0.5 active:translate-y-0 transition-all duration-300 flex items-center justify-center gap-2 group"
                            :disabled="loading">
                            <span x-show="!loading" class="flex items-center gap-2">
                                <span>Sign In</span>
                                <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                            </span>
                            <span x-show="loading" class="flex items-center gap-2">
                                <i class="fas fa-circle-notch fa-spin"></i>
                                <span>Authenticating...</span>
                            </span>
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-500">
                        Don't have an account?
                        <a href="<?php echo e(route('register')); ?>"
                            class="font-bold text-cisa-base hover:text-cisa-accent transition-colors">Register Now</a>
                    </p>
                </div>
            </div>

            <!-- Security Badge -->
            <div class="mt-8 text-center">
                <p class="text-xs text-cisa-muted flex items-center justify-center gap-2 opacity-70">
                    <i class="fas fa-shield-alt"></i>
                    Secure Login • SSL Encrypted
                </p>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u857061584/domains/cisajournal.org/public_html/resources/views/auth/login.blade.php ENDPATH**/ ?>