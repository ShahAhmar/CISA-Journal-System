

<?php $__env->startSection('title', 'Admin Dashboard - EMANP'); ?>
<?php $__env->startSection('page-title', 'Admin Dashboard'); ?>
<?php $__env->startSection('page-subtitle', 'Overview of your journal publishing platform'); ?>

<?php $__env->startSection('content'); ?>
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-6 gap-6 mb-8">
    <!-- Total Journals -->
    <a href="<?php echo e(route('admin.journals.index')); ?>" class="bg-white rounded-xl p-6 border-2 border-gray-200 hover:border-[#0056FF] hover:shadow-xl transition-all duration-300 cursor-pointer block">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-[#0056FF] rounded-lg flex items-center justify-center">
                <i class="fas fa-book text-white text-xl"></i>
            </div>
        </div>
        <div class="text-3xl font-bold text-[#0F1B4C] mb-1" style="font-family: 'Playfair Display', serif;">
            <?php echo e($stats['journals']); ?>

        </div>
        <div class="text-sm text-gray-600 font-semibold" style="font-family: 'Inter', sans-serif;">
            Total Journals
        </div>
    </a>
    
    <!-- Active Journals -->
    <a href="<?php echo e(route('admin.journals.index')); ?>" class="bg-white rounded-xl p-6 border-2 border-gray-200 hover:border-green-500 hover:shadow-xl transition-all duration-300 cursor-pointer block">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                <i class="fas fa-check-circle text-white text-xl"></i>
            </div>
        </div>
        <div class="text-3xl font-bold text-green-600 mb-1" style="font-family: 'Playfair Display', serif;">
            <?php echo e($stats['active_journals']); ?>

        </div>
        <div class="text-sm text-gray-600 font-semibold" style="font-family: 'Inter', sans-serif;">
            Active Journals
        </div>
    </a>
    
    <!-- Total Users -->
    <a href="<?php echo e(route('admin.users.index')); ?>" class="bg-white rounded-xl p-6 border-2 border-gray-200 hover:border-blue-500 hover:shadow-xl transition-all duration-300 cursor-pointer block">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                <i class="fas fa-users text-white text-xl"></i>
            </div>
        </div>
        <div class="text-3xl font-bold text-blue-600 mb-1" style="font-family: 'Playfair Display', serif;">
            <?php echo e($stats['users']); ?>

        </div>
        <div class="text-sm text-gray-600 font-semibold" style="font-family: 'Inter', sans-serif;">
            Total Users
        </div>
    </a>
    
    <!-- Total Submissions -->
    <a href="<?php echo e(route('admin.submissions.index')); ?>" class="bg-white rounded-xl p-6 border-2 border-gray-200 hover:border-purple-500 hover:shadow-xl transition-all duration-300 cursor-pointer block">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center">
                <i class="fas fa-file-upload text-white text-xl"></i>
            </div>
        </div>
        <div class="text-3xl font-bold text-purple-600 mb-1" style="font-family: 'Playfair Display', serif;">
            <?php echo e($stats['submissions']); ?>

        </div>
        <div class="text-sm text-gray-600 font-semibold" style="font-family: 'Inter', sans-serif;">
            Total Submissions
        </div>
    </a>
    
    <!-- Pending Submissions -->
    <a href="<?php echo e(route('admin.submissions.index', ['status' => 'submitted'])); ?>" class="bg-white rounded-xl p-6 border-2 border-gray-200 hover:border-orange-500 hover:shadow-xl transition-all duration-300 cursor-pointer block">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-orange-500 rounded-lg flex items-center justify-center">
                <i class="fas fa-clock text-white text-xl"></i>
            </div>
        </div>
        <div class="text-3xl font-bold text-orange-600 mb-1" style="font-family: 'Playfair Display', serif;">
            <?php echo e($stats['pending_submissions']); ?>

        </div>
        <div class="text-sm text-gray-600 font-semibold" style="font-family: 'Inter', sans-serif;">
            Pending Submissions
        </div>
    </a>
    
    <!-- Published Articles -->
    <a href="<?php echo e(route('admin.submissions.index', ['status' => 'published'])); ?>" class="bg-white rounded-xl p-6 border-2 border-gray-200 hover:border-green-600 hover:shadow-xl transition-all duration-300 cursor-pointer block">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-check-double text-white text-xl"></i>
            </div>
        </div>
        <div class="text-3xl font-bold text-green-700 mb-1" style="font-family: 'Playfair Display', serif;">
            <?php echo e($stats['published_articles']); ?>

        </div>
        <div class="text-sm text-gray-600 font-semibold" style="font-family: 'Inter', sans-serif;">
            Published Articles
        </div>
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Recent Journals -->
    <div class="bg-white rounded-xl border-2 border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-[#0F1B4C]" style="font-family: 'Playfair Display', serif;">
                Recent Journals
            </h3>
            <a href="<?php echo e(route('admin.journals.index')); ?>" class="text-[#0056FF] hover:text-[#0044CC] text-sm font-semibold transition-colors">
                View All <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
        
        <?php if($recentJournals->count() > 0): ?>
            <div class="space-y-4">
                <?php $__currentLoopData = $recentJournals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $journal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex items-center justify-between p-4 bg-[#F7F9FC] rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-[#0056FF] rounded-lg flex items-center justify-center">
                                <i class="fas fa-book text-white"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-[#0F1B4C]" style="font-family: 'Inter', sans-serif;">
                                    <?php echo e($journal->name); ?>

                                </h4>
                                <p class="text-sm text-gray-600">
                                    <?php echo e($journal->created_at->format('M d, Y')); ?>

                                </p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold <?php echo e($journal->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700'); ?>">
                                <?php echo e($journal->is_active ? 'Active' : 'Inactive'); ?>

                            </span>
                            <a href="<?php echo e(route('admin.journals.edit', $journal)); ?>" class="text-[#0056FF] hover:text-[#0044CC] transition-colors" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div class="text-center py-8">
                <i class="fas fa-book-open text-gray-400 text-4xl mb-3"></i>
                <p class="text-gray-600">No journals yet</p>
                <a href="<?php echo e(route('admin.journals.create')); ?>" class="text-[#0056FF] hover:text-[#0044CC] text-sm font-semibold mt-2 inline-block">
                    Create First Journal
                </a>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Recent Submissions -->
    <div class="bg-white rounded-xl border-2 border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-[#0F1B4C]" style="font-family: 'Playfair Display', serif;">
                Recent Submissions
            </h3>
            <a href="<?php echo e(route('admin.submissions.index')); ?>" class="text-[#0056FF] hover:text-[#0044CC] text-sm font-semibold transition-colors">
                View All <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
        
        <?php if($recentSubmissions->count() > 0): ?>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Title</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Author</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Journal</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Status</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Date</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $recentSubmissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b border-gray-100 hover:bg-[#F7F9FC] transition-colors">
                                <td class="py-3 px-4">
                                    <div class="font-semibold text-[#0F1B4C] text-sm" style="font-family: 'Inter', sans-serif;">
                                        <?php echo e(Str::limit($submission->title, 40)); ?>

                                    </div>
                                </td>
                                <td class="py-3 px-4 text-sm text-gray-600">
                                    <?php echo e($submission->author->full_name ?? 'N/A'); ?>

                                </td>
                                <td class="py-3 px-4 text-sm text-gray-600">
                                    <?php echo e($submission->journal->name ?? 'N/A'); ?>

                                </td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold 
                                        <?php if($submission->status == 'published'): ?> bg-green-100 text-green-700
                                        <?php elseif($submission->status == 'submitted'): ?> bg-orange-100 text-orange-700
                                        <?php elseif($submission->status == 'under_review'): ?> bg-blue-100 text-blue-700
                                        <?php elseif($submission->status == 'accepted'): ?> bg-green-100 text-green-700
                                        <?php else: ?> bg-gray-100 text-gray-700
                                        <?php endif; ?>">
                                        <?php echo e(ucfirst(str_replace('_', ' ', $submission->status))); ?>

                                    </span>
                                </td>
                                <td class="py-3 px-4 text-sm text-gray-600">
                                    <?php echo e($submission->created_at->format('M d, Y')); ?>

                                </td>
                                <td class="py-3 px-4">
                                    <a href="<?php echo e(route('admin.submissions.show', $submission)); ?>" class="text-[#0056FF] hover:text-[#0044CC] transition-colors text-sm" title="View Submission">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-8">
                <i class="fas fa-file-alt text-gray-400 text-4xl mb-3"></i>
                <p class="text-gray-600">No submissions yet</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Pending Tasks -->
<div class="bg-white rounded-xl border-2 border-gray-200 p-6 mb-8">
    <h3 class="text-xl font-bold text-[#0F1B4C] mb-6" style="font-family: 'Playfair Display', serif;">
        Pending Tasks
    </h3>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Review Requests -->
        <a href="<?php echo e(route('admin.reviews.index')); ?>?status=pending" class="bg-[#F7F9FC] rounded-lg p-4 border-2 border-gray-200 hover:border-blue-500 hover:shadow-lg transition-all duration-300 cursor-pointer block">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-check text-white"></i>
                </div>
                <span class="text-2xl font-bold text-blue-600"><?php echo e($pendingTasks['review_requests'] ?? 0); ?></span>
            </div>
            <h4 class="font-semibold text-[#0F1B4C] mb-1">Review Requests</h4>
            <p class="text-sm text-gray-600">Pending reviewer assignments</p>
        </a>
        
        <!-- Revision Submissions -->
        <a href="<?php echo e(route('admin.submissions.index', ['status' => 'revision_required'])); ?>" class="bg-[#F7F9FC] rounded-lg p-4 border-2 border-gray-200 hover:border-orange-500 hover:shadow-lg transition-all duration-300 cursor-pointer block">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-edit text-white"></i>
                </div>
                <span class="text-2xl font-bold text-orange-600"><?php echo e($pendingTasks['revision_submissions'] ?? 0); ?></span>
            </div>
            <h4 class="font-semibold text-[#0F1B4C] mb-1">Revision Submissions</h4>
            <p class="text-sm text-gray-600">Awaiting editor review</p>
        </a>
        
        <!-- Decisions Required -->
        <a href="<?php echo e(route('admin.submissions.index', ['status' => 'submitted'])); ?>" class="bg-[#F7F9FC] rounded-lg p-4 border-2 border-gray-200 hover:border-purple-500 hover:shadow-lg transition-all duration-300 cursor-pointer block">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-gavel text-white"></i>
                </div>
                <span class="text-2xl font-bold text-purple-600"><?php echo e($pendingTasks['decisions_required'] ?? 0); ?></span>
            </div>
            <h4 class="font-semibold text-[#0F1B4C] mb-1">Decisions Required</h4>
            <p class="text-sm text-gray-600">Awaiting editorial decision</p>
        </a>
    </div>
</div>

<!-- Activity Log -->
<div class="bg-white rounded-xl border-2 border-gray-200 p-6">
    <h3 class="text-xl font-bold text-[#0F1B4C] mb-6" style="font-family: 'Playfair Display', serif;">
        Recent Activity
    </h3>
    
    <div class="space-y-4">
        <div class="flex items-start space-x-4 p-4 bg-[#F7F9FC] rounded-lg">
            <div class="w-10 h-10 bg-[#0056FF] rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-user text-white text-sm"></i>
            </div>
            <div class="flex-1">
                <p class="text-sm text-gray-700">
                    <span class="font-semibold"><?php echo e(auth()->user()->full_name); ?></span> created journal 
                    <span class="font-semibold">"Testing Shah"</span>
                </p>
                <p class="text-xs text-gray-500 mt-1"><?php echo e(now()->subDays(1)->format('M d, Y h:i A')); ?></p>
            </div>
        </div>
        
        <div class="flex items-start space-x-4 p-4 bg-[#F7F9FC] rounded-lg">
            <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-check text-white text-sm"></i>
            </div>
            <div class="flex-1">
                <p class="text-sm text-gray-700">
                    System updated: <span class="font-semibold">1 journal</span> is now active
                </p>
                <p class="text-xs text-gray-500 mt-1"><?php echo e(now()->subHours(5)->format('M d, Y h:i A')); ?></p>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cisa\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>