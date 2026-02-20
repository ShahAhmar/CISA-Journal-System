

<?php $__env->startSection('title', 'Profile'); ?>

<?php $__env->startSection('content'); ?>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out forwards;
        }
    </style>
        <div class="min-h-screen bg-slate-50/50 py-12">
            <div class="max-w-6xl mx-auto px-4">
                <?php
                    $currentRole = $user->role ? ucfirst($user->role) : 'Reader';
                ?>

                <!-- Premium Profile Header -->
                <div
                    class="bg-cisa-base rounded-[2.5rem] p-10 mb-10 relative overflow-hidden shadow-2xl shadow-cisa-base/20 border border-slate-800">
                    <div class="absolute inset-0 opacity-10"
                        style="background-image: radial-gradient(circle, white 0.5px, transparent 0.5px); background-size: 30px 30px;">
                    </div>
                    <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-cisa-accent rounded-full opacity-5 blur-3xl"></div>

                    <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-8">
                        <div>
                            <div class="flex items-center gap-3 mb-4">
                                <span
                                    class="px-3 py-1 bg-white/10 text-white text-[10px] font-black uppercase tracking-widest rounded-full border border-white/20">
                                    Member Profile
                                </span>
                                <span class="w-1.5 h-1.5 rounded-full bg-cisa-accent"></span>
                                <span class="text-xs font-bold text-slate-400">Archival Identity</span>
                            </div>
                            <h1 class="text-4xl md:text-5xl font-black text-white tracking-tight mb-3">Settings & <span
                                    class="text-cisa-accent font-serif italic text-3xl md:text-4xl">Preferences</span></h1>
                            <p class="text-slate-400 font-medium max-w-xl">Manage your academic credentials, contact parameters,
                                and editorial notification protocols.</p>

                            <div class="mt-6 flex items-center gap-4">
                                <div class="px-4 py-2 bg-white/5 rounded-xl border border-white/10 flex items-center gap-3">
                                    <i class="fas fa-layer-group text-cisa-accent"></i>
                                    <span class="text-indigo-100 text-xs font-black uppercase tracking-widest">Role:
                                        <?php echo e($currentRole); ?></span>
                                </div>
                                <div
                                    class="px-4 py-2 bg-emerald-500/10 rounded-xl border border-emerald-500/20 flex items-center gap-3">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                    <span class="text-emerald-100 text-xs font-black uppercase tracking-widest">Account
                                        Active</span>
                                </div>
                            </div>
                        </div>

                        <div
                            class="flex items-center gap-5 bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl px-8 py-6 shadow-2xl">
                            <div class="relative group">
                                <div
                                    class="w-20 h-20 rounded-[2rem] overflow-hidden border-4 border-cisa-accent/20 group-hover:border-cisa-accent transition-all duration-500 shadow-xl">
                                    <?php if($user->profile_image): ?>
                                        <img src="<?php echo e(Storage::url($user->profile_image)); ?>" alt="Profile"
                                            class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <div
                                            class="w-full h-full bg-cisa-accent flex items-center justify-center text-cisa-base text-2xl font-black">
                                            <?php echo e(strtoupper(substr($user->first_name, 0, 1))); ?><?php echo e(strtoupper(substr($user->last_name, 0, 1))); ?>

                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div
                                    class="absolute -bottom-1 -right-1 w-6 h-6 bg-cisa-accent rounded-lg border-2 border-[#0f172a] flex items-center justify-center shadow-lg">
                                    <i class="fas fa-check text-[8px] text-cisa-base font-black"></i>
                                </div>
                            </div>
                            <div>
                                <p class="text-xl font-black text-white tracking-tight leading-none mb-2">
                                    <?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?></p>
                                <p class="text-xs font-bold text-slate-400 opacity-80"><?php echo e($user->email); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if(session('status')): ?>
                    <div class="mb-4 rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-green-800">
                        <?php echo e(session('status')); ?>

                    </div>
                <?php endif; ?>

                <?php if($errors->any()): ?>
                    <div class="mb-4 rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-red-800">
                        <ul class="list-disc list-inside space-y-1">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <div x-data="{ tab: 'identity' }"
                    class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200 border border-slate-100 overflow-hidden">
                    <div class="flex flex-wrap border-b border-slate-100 bg-slate-50/50 p-2">
                        <?php
                            $tabs = [
                                'identity' => ['label' => 'Identity', 'icon' => 'fa-id-card'],
                                'contact' => ['label' => 'Contact', 'icon' => 'fa-paper-plane'],
                                'public' => ['label' => 'Public Profile', 'icon' => 'fa-globe'],
                                'password' => ['label' => 'Security', 'icon' => 'fa-shield-halved'],
                                'notifications' => ['label' => 'Directives', 'icon' => 'fa-bell'],
                            ];
                        ?>
                        <?php $__currentLoopData = $tabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $tab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <button type="button" @click="tab = '<?php echo e($key); ?>'"
                                :class="tab === '<?php echo e($key); ?>' ? 'text-cisa-base bg-white shadow-lg shadow-slate-200/50' : 'text-slate-400 hover:text-slate-600 hover:bg-white/50'"
                                class="flex items-center gap-3 px-8 py-4 text-[10px] font-black uppercase tracking-[0.2em] rounded-2xl transition-all duration-300">
                                <i class="fas <?php echo e($tab['icon']); ?> text-xs"
                                    :class="tab === '<?php echo e($key); ?>' ? 'text-cisa-accent' : 'text-slate-300'"></i>
                                <span><?php echo e($tab['label']); ?></span>
                            </button>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <div class="p-10 space-y-10">
                        
                        <div x-show="tab === 'identity'" x-cloak class="animate-fadeIn">
                            <div class="flex items-center gap-4 mb-8">
                                <div class="w-12 h-12 bg-cisa-base rounded-2xl flex items-center justify-center shadow-lg">
                                    <i class="fas fa-id-card text-cisa-accent"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-black text-cisa-base tracking-tight">Identity Parameters</h3>
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Primary archivist
                                        metadata</p>
                                </div>
                            </div>

                            <form method="POST" action="<?php echo e(route('profile.update.identity')); ?>" class="space-y-8">
                                <?php echo csrf_field(); ?>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div>
                                        <label
                                            class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Given
                                            Name <span class="text-red-500">*</span></label>
                                        <input type="text" name="first_name" value="<?php echo e(old('first_name', $user->first_name)); ?>"
                                            required
                                            class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl text-cisa-base font-bold placeholder:text-slate-300 focus:outline-none focus:border-cisa-base focus:bg-white transition-all shadow-sm">
                                    </div>
                                    <div>
                                        <label
                                            class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Surname
                                            <span class="text-red-500">*</span></label>
                                        <input type="text" name="last_name" value="<?php echo e(old('last_name', $user->last_name)); ?>"
                                            required
                                            class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl text-cisa-base font-bold placeholder:text-slate-300 focus:outline-none focus:border-cisa-base focus:bg-white transition-all shadow-sm">
                                    </div>
                                </div>
                                <div>
                                    <label
                                        class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Email
                                        Transmission Endpoint <span class="text-red-500">*</span></label>
                                    <input type="email" name="email" value="<?php echo e(old('email', $user->email)); ?>" required
                                        class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl text-cisa-base font-bold placeholder:text-slate-300 focus:outline-none focus:border-cisa-base focus:bg-white transition-all shadow-sm">
                                </div>
                                <div class="pt-4">
                                    <button type="submit"
                                        class="px-10 py-4 cisa-gradient text-white rounded-[1.5rem] font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-cisa-base/30 hover:scale-[1.03] transition-all flex items-center gap-3">
                                        <i class="fas fa-floppy-disk text-cisa-accent"></i>
                                        Commit Identity Changes
                                    </button>
                                </div>
                            </form>
                        </div>

                        
                        <div x-show="tab === 'contact'" x-cloak class="animate-fadeIn">
                            <div class="flex items-center gap-4 mb-8">
                                <div class="w-12 h-12 bg-cisa-base rounded-2xl flex items-center justify-center shadow-lg">
                                    <i class="fas fa-paper-plane text-cisa-accent"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-black text-cisa-base tracking-tight">Communication Protocols</h3>
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Reachability &
                                        professional affiliation</p>
                                </div>
                            </div>

                            <form method="POST" action="<?php echo e(route('profile.update.contact')); ?>" class="space-y-8">
                                <?php echo csrf_field(); ?>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div>
                                        <label
                                            class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Direct
                                            Phone Access</label>
                                        <input type="text" name="phone" value="<?php echo e(old('phone', $user->phone)); ?>"
                                            class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl text-cisa-base font-bold placeholder:text-slate-300 focus:outline-none focus:border-cisa-base focus:bg-white transition-all shadow-sm">
                                    </div>
                                    <div>
                                        <label
                                            class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Institutional
                                            Affiliation</label>
                                        <input type="text" name="affiliation"
                                            value="<?php echo e(old('affiliation', $user->affiliation)); ?>"
                                            class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl text-cisa-base font-bold placeholder:text-slate-300 focus:outline-none focus:border-cisa-base focus:bg-white transition-all shadow-sm">
                                    </div>
                                </div>
                                <div>
                                    <label
                                        class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">ORCID
                                        Intelligence Identifier</label>
                                    <input type="text" name="orcid" value="<?php echo e(old('orcid', $user->orcid)); ?>"
                                        class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl text-cisa-base font-bold placeholder:text-slate-300 focus:outline-none focus:border-cisa-base focus:bg-white transition-all shadow-sm"
                                        placeholder="0000-0000-0000-0000">
                                </div>
                                <div class="pt-4">
                                    <button type="submit"
                                        class="px-10 py-4 cisa-gradient text-white rounded-[1.5rem] font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-cisa-base/30 hover:scale-[1.03] transition-all flex items-center gap-3">
                                        <i class="fas fa-check-double text-cisa-accent"></i>
                                        Save Communication Grid
                                    </button>
                                </div>
                            </form>
                        </div>

                    
                    <div x-show="tab === 'public'" x-cloak class="animate-fadeIn">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-12 h-12 bg-cisa-base rounded-2xl flex items-center justify-center shadow-lg">
                                <i class="fas fa-globe text-cisa-accent"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-black text-cisa-base tracking-tight">Public Presence</h3>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Global identity & scholarly bio</p>
                            </div>
                        </div>

                        <form method="POST" action="<?php echo e(route('profile.update.public')); ?>" enctype="multipart/form-data" class="space-y-8">
                            <?php echo csrf_field(); ?>
                            <div class="flex items-center gap-8 bg-slate-50 p-8 rounded-[2rem] border-2 border-slate-100">
                                <div class="relative group">
                                    <div class="w-24 h-24 rounded-[2rem] overflow-hidden border-4 border-white shadow-xl bg-white">
                                        <?php if($user->profile_image): ?>
                                            <img src="<?php echo e(Storage::url($user->profile_image)); ?>" alt="Profile" class="w-full h-full object-cover">
                                        <?php else: ?>
                                            <div class="w-full h-full flex items-center justify-center text-slate-200 bg-slate-50">
                                                <i class="fas fa-user text-3xl"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Profile Identity Image</label>
                                    <input type="file" name="profile_image" accept="image/*"
                                        class="block w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-6 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:tracking-widest file:bg-cisa-base file:text-white hover:file:bg-slate-800 transition-all">
                                    <p class="text-[10px] font-bold text-slate-400 mt-2 uppercase tracking-tighter">Recommended: 400x400px • Max 2MB</p>
                                </div>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Scholarly Biography</label>
                                <textarea name="bio" rows="5" 
                                    class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl text-cisa-base font-bold placeholder:text-slate-300 focus:outline-none focus:border-cisa-base focus:bg-white transition-all shadow-sm" 
                                    placeholder="Detail your research trajectories and academic expertise..."><?php echo e(old('bio', $user->bio)); ?></textarea>
                            </div>
                            <div class="pt-4">
                                <button type="submit" class="px-10 py-4 cisa-gradient text-white rounded-[1.5rem] font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-cisa-base/30 hover:scale-[1.03] transition-all flex items-center gap-3">
                                    <i class="fas fa-feather-pointed text-cisa-accent"></i>
                                    Publish Public Identity
                                </button>
                            </div>
                        </form>
                    </div>

                    
                    <div x-show="tab === 'password'" x-cloak class="animate-fadeIn">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-12 h-12 bg-cisa-base rounded-2xl flex items-center justify-center shadow-lg">
                                <i class="fas fa-shield-halved text-cisa-accent"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-black text-cisa-base tracking-tight">Security Encryption</h3>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Account access & integrity protection</p>
                            </div>
                        </div>

                        <form method="POST" action="<?php echo e(route('profile.update.password')); ?>" class="space-y-8">
                            <?php echo csrf_field(); ?>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Current Authorization</label>
                                    <input type="password" name="current_password" required
                                        class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl text-cisa-base font-bold placeholder:text-slate-300 focus:outline-none focus:border-cisa-base focus:bg-white transition-all shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">New Credentials</label>
                                    <input type="password" name="password" required
                                        class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl text-cisa-base font-bold placeholder:text-slate-300 focus:outline-none focus:border-cisa-base focus:bg-white transition-all shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Confirm Redefinition</label>
                                    <input type="password" name="password_confirmation" required
                                        class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl text-cisa-base font-bold placeholder:text-slate-300 focus:outline-none focus:border-cisa-base focus:bg-white transition-all shadow-sm">
                                </div>
                            </div>
                            <div class="pt-4">
                                <button type="submit" class="px-10 py-4 cisa-gradient text-white rounded-[1.5rem] font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-cisa-base/30 hover:scale-[1.03] transition-all flex items-center gap-3">
                                    <i class="fas fa-lock-open text-cisa-accent"></i>
                                    Revise Security Credentials
                                </button>
                            </div>
                        </form>
                    </div>

                    
                    <div x-show="tab === 'notifications'" x-cloak class="animate-fadeIn">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-12 h-12 bg-cisa-base rounded-2xl flex items-center justify-center shadow-lg">
                                <i class="fas fa-bell text-cisa-accent"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-black text-cisa-base tracking-tight">Directives & Alerts</h3>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Subscription status & system intelligence</p>
                            </div>
                        </div>

                        <form method="POST" action="<?php echo e(route('profile.update.notifications')); ?>" class="space-y-8">
                            <?php echo csrf_field(); ?>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <label class="cursor-pointer group">
                                    <input type="checkbox" name="notify_system" value="1" <?php if(old('notify_system', $user->notify_system)): echo 'checked'; endif; ?> class="hidden peer">
                                    <div class="h-full bg-slate-50 border-2 border-slate-100 rounded-[2rem] p-8 transition-all duration-300 peer-checked:border-cisa-base peer-checked:bg-white peer-checked:shadow-2xl peer-checked:shadow-cisa-base/10 group-hover:bg-white">
                                        <div class="flex items-center justify-between mb-6">
                                            <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center shadow-md border-2 border-slate-50 peer-checked:border-cisa-accent">
                                                <i class="fas fa-microchip text-slate-400 peer-checked:text-cisa-accent transition-colors"></i>
                                            </div>
                                            <div class="w-6 h-6 rounded-full border-2 border-slate-200 flex items-center justify-center peer-checked:bg-cisa-accent peer-checked:border-cisa-accent">
                                                <i class="fas fa-check text-[10px] text-white opacity-0 peer-checked:opacity-100"></i>
                                            </div>
                                        </div>
                                        <h4 class="text-lg font-black text-cisa-base mb-2">System Integrations</h4>
                                        <p class="text-xs font-bold text-slate-400 leading-relaxed uppercase tracking-tight">Real-time alerts regarding submission status, review assignments, and archival checkpoints.</p>
                                    </div>
                                </label>

                                <label class="cursor-pointer group">
                                    <input type="checkbox" name="notify_marketing" value="1" <?php if(old('notify_marketing', $user->notify_marketing)): echo 'checked'; endif; ?> class="hidden peer">
                                    <div class="h-full bg-slate-50 border-2 border-slate-100 rounded-[2rem] p-8 transition-all duration-300 peer-checked:border-cisa-base peer-checked:bg-white peer-checked:shadow-2xl peer-checked:shadow-cisa-base/10 group-hover:bg-white">
                                        <div class="flex items-center justify-between mb-6">
                                            <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center shadow-md border-2 border-slate-50 peer-checked:border-cisa-accent">
                                                <i class="fas fa-bullhorn text-slate-400 peer-checked:text-cisa-accent transition-colors"></i>
                                            </div>
                                            <div class="w-6 h-6 rounded-full border-2 border-slate-200 flex items-center justify-center peer-checked:bg-cisa-accent peer-checked:border-cisa-accent">
                                                <i class="fas fa-check text-[10px] text-white opacity-0 peer-checked:opacity-100"></i>
                                            </div>
                                        </div>
                                        <h4 class="text-lg font-black text-cisa-base mb-2">Editorial Intelligence</h4>
                                        <p class="text-xs font-bold text-slate-400 leading-relaxed uppercase tracking-tight">Exclusive updates on journal calls, industry newsletters, and upcoming scholarly symposiums.</p>
                                    </div>
                                </label>
                            </div>
                            <div class="pt-4 border-t border-slate-100">
                                <button type="submit" class="px-10 py-4 cisa-gradient text-white rounded-[1.5rem] font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-cisa-base/30 hover:scale-[1.03] transition-all flex items-center gap-3">
                                    <i class="fas fa-satellite-dish text-cisa-accent"></i>
                                    Commit Directive Settings
                                </button>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u857061584/domains/cisajournal.org/public_html/resources/views/profile/edit.blade.php ENDPATH**/ ?>