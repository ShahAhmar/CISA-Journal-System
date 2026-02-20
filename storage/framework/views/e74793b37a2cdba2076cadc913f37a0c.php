<?php $__env->startSection('title', 'Register - CISA Interdisciplinary Journal'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen flex items-center justify-center bg-slate-50 py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- Background Patterns -->
    <div class="fixed inset-0 pointer-events-none opacity-5">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
    </div>
    
    <div class="max-w-2xl w-full relative z-10">
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <a href="<?php echo e(route('journals.index')); ?>" class="inline-block mb-6 group">
                <div class="w-20 h-20 bg-cisa-base rounded-2xl flex items-center justify-center shadow-xl transform group-hover:scale-105 transition-transform duration-300 mx-auto border-2 border-cisa-accent">
                    <i class="fas fa-user-plus text-3xl text-cisa-accent"></i>
                </div>
            </a>
            <h1 class="text-3xl font-bold font-serif text-cisa-base mb-2">
                Join our Academic Community
            </h1>
            <p class="text-cisa-muted">Create an account to submit manuscripts and track reviews</p>
        </div>

        <!-- Error Messages -->
        <?php if($errors->any()): ?>
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500 mt-1"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-bold text-red-800">Registration Error</h3>
                        <ul class="list-disc list-inside text-sm text-red-700 mt-1">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Registration Form -->
        <div class="bg-white rounded-xl shadow-glass border border-gray-100 p-8 md:p-10 relative overflow-hidden">
             <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-cisa-base via-cisa-accent to-cisa-base"></div>
            
            <form class="space-y-6" method="POST" action="<?php echo e(route('register')); ?>" 
                  x-data="{ 
                      showPassword: false, 
                      showConfirmPassword: false,
                      loading: false,
                      password: '',
                      passwordStrength: 0,
                      checkPasswordStrength(pwd) {
                          if (!pwd) return 0;
                          let strength = 0;
                          if (pwd.length >= 8) strength++;
                          if (pwd.match(/[a-z]+/)) strength++;
                          if (pwd.match(/[A-Z]+/)) strength++;
                          if (pwd.match(/[0-9]+/)) strength++;
                          if (pwd.match(/[$@#&!]+/)) strength++;
                          return strength;
                      }
                  }"
                  @submit="loading = true">
                <?php echo csrf_field(); ?>
                
                <!-- Name Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="first_name" class="block text-sm font-bold text-cisa-base mb-2">
                            First Name <span class="text-red-500">*</span>
                        </label>
                        <input id="first_name" name="first_name" type="text" required 
                               class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-cisa-accent/50 focus:border-cisa-accent transition-all duration-300 bg-slate-50 focus:bg-white text-cisa-base" 
                               placeholder="John" 
                               value="<?php echo e(old('first_name')); ?>">
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-bold text-cisa-base mb-2">
                            Last Name <span class="text-red-500">*</span>
                        </label>
                        <input id="last_name" name="last_name" type="text" required 
                               class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-cisa-accent/50 focus:border-cisa-accent transition-all duration-300 bg-slate-50 focus:bg-white text-cisa-base" 
                               placeholder="Doe" 
                               value="<?php echo e(old('last_name')); ?>">
                    </div>
                </div>

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-bold text-cisa-base mb-2">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <div class="relative group">
                        <input id="email" name="email" type="email" required 
                               class="w-full px-4 py-3 pl-10 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-cisa-accent/50 focus:border-cisa-accent transition-all duration-300 bg-slate-50 focus:bg-white text-cisa-base" 
                               placeholder="name@institution.edu" 
                               value="<?php echo e(old('email')); ?>">
                        <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-cisa-accent transition-colors"></i>
                    </div>
                </div>

                <!-- Password Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="block text-sm font-bold text-cisa-base mb-2">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative group">
                            <input id="password" name="password" 
                                   :type="showPassword ? 'text' : 'password'" 
                                   required 
                                   class="w-full px-4 py-3 pl-10 pr-10 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-cisa-accent/50 focus:border-cisa-accent transition-all duration-300 bg-slate-50 focus:bg-white text-cisa-base" 
                                   placeholder="Min. 8 characters"
                                   x-model="password"
                                   @input="passwordStrength = checkPasswordStrength($event.target.value)">
                            <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-cisa-accent transition-colors"></i>
                            <button type="button" 
                                    @click="showPassword = !showPassword"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-cisa-base transition-colors focus:outline-none">
                                <i class="fas" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                        
                        <!-- Strength Bar -->
                        <div x-show="password && password.length > 0" class="mt-2 transition-all duration-300" x-cloak>
                            <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                                <div class="h-1.5 rounded-full transition-all duration-500"
                                     :class="{
                                         'bg-red-500 w-1/5': passwordStrength <= 2,
                                         'bg-cisa-accent w-3/5': passwordStrength === 3,
                                         'bg-green-500 w-full': passwordStrength >= 4
                                     }"></div>
                            </div>
                            <p class="text-[10px] text-gray-400 mt-1 text-right" x-text="['Weak', 'Weak', 'Fair', 'Good', 'Strong', 'Excellent'][passwordStrength] || 'Weak'"></p>
                        </div>
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold text-cisa-base mb-2">
                            Confirm Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative group">
                            <input id="password_confirmation" name="password_confirmation" 
                                   :type="showConfirmPassword ? 'text' : 'password'" 
                                   required 
                                   class="w-full px-4 py-3 pl-10 pr-10 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-cisa-accent/50 focus:border-cisa-accent transition-all duration-300 bg-slate-50 focus:bg-white text-cisa-base" 
                                   placeholder="Re-enter password">
                            <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-cisa-accent transition-colors"></i>
                            <button type="button" 
                                    @click="showConfirmPassword = !showConfirmPassword"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-cisa-base transition-colors focus:outline-none">
                                <i class="fas" :class="showConfirmPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Affiliation & ORCID -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="affiliation" class="block text-sm font-bold text-cisa-base mb-2">
                            Affiliation <span class="text-gray-400 font-normal text-xs">(Optional)</span>
                        </label>
                        <input id="affiliation" name="affiliation" type="text" 
                               class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-cisa-accent/50 focus:border-cisa-accent transition-all duration-300 bg-slate-50 focus:bg-white text-cisa-base" 
                               placeholder="University/Institution" 
                               value="<?php echo e(old('affiliation')); ?>">
                    </div>
                    <div>
                         <label for="orcid" class="block text-sm font-bold text-cisa-base mb-2">
                            ORCID ID <span class="text-gray-400 font-normal text-xs">(Optional)</span>
                        </label>
                        <div class="relative group">
                            <input id="orcid" name="orcid" type="text" 
                                   class="w-full px-4 py-3 pl-10 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-cisa-accent/50 focus:border-cisa-accent transition-all duration-300 bg-slate-50 focus:bg-white text-cisa-base" 
                                   placeholder="0000-0000-0000-0000" 
                                   value="<?php echo e(old('orcid')); ?>">
                            <i class="fab fa-orcid absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-cisa-accent transition-colors"></i>
                        </div>
                    </div>
                </div>

                <!-- Terms -->
                <div class="flex items-start bg-slate-50 p-4 rounded-lg border border-gray-100">
                    <input id="terms" name="terms" type="checkbox" required
                           class="h-4 w-4 text-cisa-accent focus:ring-cisa-accent border-gray-300 rounded mt-1 cursor-pointer">
                    <label for="terms" class="ml-3 block text-sm text-gray-600 cursor-pointer">
                        I agree to the <a href="#" class="text-cisa-base font-bold underline decoration-cisa-accent decoration-2 underline-offset-2 hover:text-cisa-accent transition-colors">Terms & Conditions</a> 
                        and <a href="#" class="text-cisa-base font-bold underline decoration-cisa-accent decoration-2 underline-offset-2 hover:text-cisa-accent transition-colors">Privacy Policy</a>
                        <span class="text-red-500">*</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" 
                            class="w-full bg-cisa-base text-white font-bold py-4 px-6 rounded-lg shadow-lg hover:shadow-xl hover:bg-slate-800 transform hover:-translate-y-0.5 active:translate-y-0 transition-all duration-300 flex items-center justify-center gap-2 group"
                            :disabled="loading">
                        <span x-show="!loading" class="flex items-center gap-2">
                            <i class="fas fa-user-plus"></i>
                            <span>Create Account</span>
                        </span>
                        <span x-show="loading" class="flex items-center gap-2">
                            <i class="fas fa-circle-notch fa-spin"></i>
                            <span>Processing...</span>
                        </span>
                    </button>
                </div>
            </form>
            
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-500">
                    Already have an account? 
                    <a href="<?php echo e(route('login')); ?>" class="font-bold text-cisa-base hover:text-cisa-accent transition-colors">Sign In</a>
                </p>
            </div>
        </div>

        <!-- Security Badge -->
        <div class="mt-8 text-center">
            <p class="text-xs text-cisa-muted flex items-center justify-center gap-2 opacity-70">
                <i class="fas fa-shield-alt"></i>
                Your data is protected by industry standard encryption
            </p>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u857061584/domains/cisajournal.org/public_html/resources/views/auth/register.blade.php ENDPATH**/ ?>