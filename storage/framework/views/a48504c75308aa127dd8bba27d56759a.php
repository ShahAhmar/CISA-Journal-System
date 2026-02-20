<?php $__env->startSection('title', 'Create New Journal - CISA'); ?>
<?php $__env->startSection('page-title', 'Create New Journal'); ?>
<?php $__env->startSection('page-subtitle', 'Initialize a new academic journal'); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        .quill-editor {
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            background: #f8fafc;
        }

        .quill-editor:focus-within {
            border-color: #f59e0b;
            background: #fff;
            box-shadow: 0 0 0 2px rgba(245, 158, 11, 0.1);
        }

        .ql-toolbar {
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
            border: none;
            border-bottom: 1px solid #e2e8f0;
            background: #fff;
        }

        .ql-container {
            border-bottom-left-radius: 0.5rem;
            border-bottom-right-radius: 0.5rem;
            border: none;
            border-top: none;
            font-family: 'Inter', sans-serif;
        }

        .tab-btn {
            position: relative;
            transition: all 0.3s ease;
        }

        .tab-btn::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 2px;
            background: transparent;
            transition: all 0.3s ease;
        }

        .tab-btn.active {
            color: #f59e0b;
            background: rgba(245, 158, 11, 0.05);
        }

        .tab-btn.active::after {
            background: #f59e0b;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div x-data="{ activeTab: 'basic' }">
        <form method="POST" action="<?php echo e(route('admin.journals.store')); ?>" enctype="multipart/form-data" id="journalForm">
            <?php echo csrf_field(); ?>

            <?php if($errors->any()): ?>
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700 font-bold">
                                There are some errors in your form. Please check all tabs.
                            </p>
                            <ul class="mt-1 list-disc list-inside text-xs text-red-600">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Tabs Navigation -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6 sticky top-0 z-30">
                <div class="flex overflow-x-auto p-2 gap-1 no-scrollbar">
                    <button type="button" @click="activeTab = 'basic'"
                        :class="activeTab === 'basic' ? 'active font-bold' : 'text-gray-500 hover:text-cisa-base font-medium'"
                        class="tab-btn px-4 py-3 rounded-lg text-sm whitespace-nowrap flex items-center gap-2">
                        <i class="fas fa-cog"></i>Basic Settings
                    </button>
                    <button type="button" @click="activeTab = 'homepage'"
                        :class="activeTab === 'homepage' ? 'active font-bold' : 'text-gray-500 hover:text-cisa-base font-medium'"
                        class="tab-btn px-4 py-3 rounded-lg text-sm whitespace-nowrap flex items-center gap-2">
                        <i class="fas fa-home"></i>Homepage
                    </button>
                    <button type="button" @click="activeTab = 'about'"
                        :class="activeTab === 'about' ? 'active font-bold' : 'text-gray-500 hover:text-cisa-base font-medium'"
                        class="tab-btn px-4 py-3 rounded-lg text-sm whitespace-nowrap flex items-center gap-2">
                        <i class="fas fa-info-circle"></i>About Page
                    </button>
                    <button type="button" @click="activeTab = 'info'"
                        :class="activeTab === 'info' ? 'active font-bold' : 'text-gray-500 hover:text-cisa-base font-medium'"
                        class="tab-btn px-4 py-3 rounded-lg text-sm whitespace-nowrap flex items-center gap-2">
                        <i class="fas fa-book-open"></i>Journal Info
                    </button>
                    <button type="button" @click="activeTab = 'editorial'"
                        :class="activeTab === 'editorial' ? 'active font-bold' : 'text-gray-500 hover:text-cisa-base font-medium'"
                        class="tab-btn px-4 py-3 rounded-lg text-sm whitespace-nowrap flex items-center gap-2">
                        <i class="fas fa-users"></i>Editorial & Ethics
                    </button>
                    <button type="button" @click="activeTab = 'apc'"
                        :class="activeTab === 'apc' ? 'active font-bold' : 'text-gray-500 hover:text-cisa-base font-medium'"
                        class="tab-btn px-4 py-3 rounded-lg text-sm whitespace-nowrap flex items-center gap-2">
                        <i class="fas fa-file-invoice-dollar"></i>APC & Submission
                    </button>
                    <button type="button" @click="activeTab = 'cfp'"
                        :class="activeTab === 'cfp' ? 'active font-bold' : 'text-gray-500 hover:text-cisa-base font-medium'"
                        class="tab-btn px-4 py-3 rounded-lg text-sm whitespace-nowrap flex items-center gap-2">
                        <i class="fas fa-bullhorn"></i>Call for Papers
                    </button>
                    <button type="button" @click="activeTab = 'contact'"
                        :class="activeTab === 'contact' ? 'active font-bold' : 'text-gray-500 hover:text-cisa-base font-medium'"
                        class="tab-btn px-4 py-3 rounded-lg text-sm whitespace-nowrap flex items-center gap-2">
                        <i class="fas fa-address-card"></i>Contact
                    </button>
                </div>
            </div>

            <div class="space-y-6 pb-20">
                <!-- Tab 1: Basic Settings -->
                <div x-show="activeTab === 'basic'" class="space-y-6" x-transition:enter="transition ease-out duration-300">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                        <h2 class="text-xl font-bold text-cisa-base font-serif mb-6 border-b pb-2">Basic Information</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold text-cisa-base mb-2">Journal Name <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="name" value="<?php echo e(old('name')); ?>" required
                                    class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all">
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">Initials</label>
                                <input type="text" name="journal_initials" value="<?php echo e(old('journal_initials')); ?>"
                                    class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">Abbreviation</label>
                                <input type="text" name="journal_abbreviation" value="<?php echo e(old('journal_abbreviation')); ?>"
                                    class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">URL Slug</label>
                                <input type="text" name="slug" value="<?php echo e(old('slug')); ?>"
                                    class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg font-mono text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">Website URL</label>
                                <input type="url" name="journal_url" value="<?php echo e(old('journal_url')); ?>"
                                    class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">Impact Factor</label>
                                <input type="number" step="0.01" name="impact_factor"
                                    value="<?php echo e(old('impact_factor', '2.50')); ?>" placeholder="e.g. 2.50"
                                    class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg">
                                <p class="mt-1 text-[10px] text-gray-400 font-bold uppercase tracking-widest leading-none">
                                    Sets the initial numerical value displayed on the portal.</p>
                                <?php $__errorArgs = ['impact_factor'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-8 pt-4">
                                <div class="p-6 border-2 border-dashed border-gray-200 rounded-xl text-center">
                                    <label class="block font-bold text-cisa-base mb-2">Journal Logo</label>
                                    <input type="file" name="logo" class="w-full text-sm text-gray-400">
                                </div>
                                <div class="p-6 border-2 border-dashed border-gray-200 rounded-xl text-center">
                                    <label class="block font-bold text-cisa-base mb-2">Cover Image</label>
                                    <input type="file" name="cover_image" class="w-full text-sm text-gray-400">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab 2: Homepage Content -->
                <div x-show="activeTab === 'homepage'" class="space-y-6" x-cloak>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                        <h2 class="text-xl font-bold text-cisa-base font-serif mb-6 border-b pb-2">Homepage Content
                            (`show.blade.php`)</h2>
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">Header Badge Text</label>
                                <input type="text" name="badge_text" value="<?php echo e(old('badge_text')); ?>"
                                    placeholder="e.g. Peer Reviewed & Open Access"
                                    class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:border-cisa-accent outline-none">
                                <p class="mt-1 text-xs text-gray-400">This text appears in a gold badge in the journal
                                    header. Leave empty for default.</p>
                                <?php $__errorArgs = ['badge_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">Description / Intro Text</label>
                                <div id="description-editor" class="quill-editor h-32"></div>
                                <textarea name="description" id="description"
                                    class="hidden"><?php echo e(old('description')); ?></textarea>
                                <p class="text-xs text-gray-400 mt-1">Displayed on Layout Landing Page (if multiple
                                    journals) and in About snippets.</p>
                                <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">Hero Section Content</label>
                                <div id="homepage_content-editor" class="quill-editor h-32"></div>
                                <textarea name="homepage_content" id="homepage_content"
                                    class="hidden"><?php echo e(old('homepage_content')); ?></textarea>
                                <p class="text-xs text-gray-400 mt-1">Custom content for the main hero section.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab 3: About Page -->
                <div x-show="activeTab === 'about'" class="space-y-6" x-cloak>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                        <h2 class="text-xl font-bold text-cisa-base font-serif mb-6 border-b pb-2">About Page Content</h2>
                        <div class="space-y-8">
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">Vision Statement</label>
                                <div id="vision-editor" class="quill-editor h-32"></div>
                                <textarea name="vision" id="vision" class="hidden"><?php echo e(old('vision')); ?></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">Mission Statement</label>
                                <div id="mission-editor" class="quill-editor h-32"></div>
                                <textarea name="mission" id="mission" class="hidden"><?php echo e(old('mission')); ?></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">Aims & Scope</label>
                                <div id="aims_scope-editor" class="quill-editor h-48"></div>
                                <textarea name="aims_scope" id="aims_scope"
                                    class="hidden"><?php echo e(old('aims_scope')); ?></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">Publication Frequency</label>
                                <div id="publication_frequency-editor" class="quill-editor h-24"></div>
                                <textarea name="publication_frequency" id="publication_frequency"
                                    class="hidden"><?php echo e(old('publication_frequency')); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab 4: Journal Info -->
                <div x-show="activeTab === 'info'" class="space-y-6" x-cloak>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                        <h2 class="text-xl font-bold text-cisa-base font-serif mb-6 border-b pb-2">Journal Info Page</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">Print ISSN</label>
                                <input type="text" name="print_issn" value="<?php echo e(old('print_issn')); ?>"
                                    class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg font-mono">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">Online ISSN</label>
                                <input type="text" name="online_issn" value="<?php echo e(old('online_issn')); ?>"
                                    class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg font-mono">
                            </div>
                        </div>
                        <div class="space-y-8">
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">Peer Review Process</label>
                                <div id="peer_review_process-editor" class="quill-editor h-32"></div>
                                <textarea name="peer_review_process" id="peer_review_process"
                                    class="hidden"><?php echo e(old('peer_review_process')); ?></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">Open Access Policy</label>
                                <div id="open_access_policy-editor" class="quill-editor h-32"></div>
                                <textarea name="open_access_policy" id="open_access_policy"
                                    class="hidden"><?php echo e(old('open_access_policy')); ?></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">Copyright Notice</label>
                                <div id="copyright_notice-editor" class="quill-editor h-32"></div>
                                <textarea name="copyright_notice" id="copyright_notice"
                                    class="hidden"><?php echo e(old('copyright_notice')); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab 5: Editorial & Ethics -->
                <div x-show="activeTab === 'editorial'" class="space-y-6" x-cloak>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                        <h2 class="text-xl font-bold text-cisa-base font-serif mb-6 border-b pb-2">Editorial & Ethics Page
                        </h2>
                        <div class="space-y-8">
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">Editor-in-Chief</label>
                                <div id="editor_in_chief-editor" class="quill-editor h-32"></div>
                                <textarea name="editor_in_chief" id="editor_in_chief"
                                    class="hidden"><?php echo e(old('editor_in_chief')); ?></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">Editorial Board Members</label>
                                <div id="editorial_board_members-editor" class="quill-editor h-48"></div>
                                <textarea name="editorial_board_members" id="editorial_board_members"
                                    class="hidden"><?php echo e(old('editorial_board_members')); ?></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">Ethics Policy</label>
                                <div id="ethics_policy-editor" class="quill-editor h-48"></div>
                                <textarea name="ethics_policy" id="ethics_policy"
                                    class="hidden"><?php echo e(old('ethics_policy')); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab 6: APC & Submission -->
                <div x-show="activeTab === 'apc'" class="space-y-6" x-cloak>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                        <h2 class="text-xl font-bold text-cisa-base font-serif mb-6 border-b pb-2">APC & Submission Page
                        </h2>
                        <div class="space-y-8">
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">APC Policy (Article Processing
                                    Charges)</label>
                                <div id="apc_policy-editor" class="quill-editor h-32"></div>
                                <textarea name="apc_policy" id="apc_policy"
                                    class="hidden"><?php echo e(old('apc_policy')); ?></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">Submission Guidelines</label>
                                <div id="submission_guidelines-editor" class="quill-editor h-48"></div>
                                <textarea name="submission_guidelines" id="submission_guidelines"
                                    class="hidden"><?php echo e(old('submission_guidelines')); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab 7: Call for Papers -->
                <div x-show="activeTab === 'cfp'" class="space-y-6" x-cloak>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                        <h2 class="text-xl font-bold text-cisa-base font-serif mb-6 border-b pb-2">Call for Papers Page</h2>
                        <div>
                            <label class="block text-sm font-bold text-cisa-base mb-2">Call for Papers Content</label>
                            <div id="call_for_papers-editor" class="quill-editor h-64"></div>
                            <textarea name="call_for_papers" id="call_for_papers"
                                class="hidden"><?php echo e(old('call_for_papers')); ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- Tab 8: Contact -->
                <div x-show="activeTab === 'contact'" class="space-y-6" x-cloak>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                        <h2 class="text-xl font-bold text-cisa-base font-serif mb-6 border-b pb-2">Contact Page & Footer
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">Primary Contact Name</label>
                                <input type="text" name="primary_contact_name" value="<?php echo e(old('primary_contact_name')); ?>"
                                    class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">Primary Contact Email</label>
                                <input type="email" name="primary_contact_email" value="<?php echo e(old('primary_contact_email')); ?>"
                                    class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold text-cisa-base mb-2">Mailing Address</label>
                                <textarea name="contact_address" rows="4"
                                    class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg"><?php echo e(old('contact_address')); ?></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- Placeholder for Disciplines -->
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 flex items-start gap-4">
                        <i class="fas fa-info-circle text-blue-500 mt-1"></i>
                        <div>
                            <h3 class="font-bold text-blue-900">Disciplines & Page Names</h3>
                            <p class="text-blue-800 text-sm mt-1">
                                You can manage specific <strong>Disciplines</strong> (for filtering) and customize
                                <strong>Page Names</strong> (e.g. rename 'About CIJ' to 'About Us') after creating the
                                journal.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sticky Footer for Actions -->
            <div
                class="fixed bottom-0 right-0 w-full md:w-[calc(100%-18rem)] bg-white border-t border-gray-200 p-4 shadow-lg z-40 flex justify-end gap-4">
                <a href="<?php echo e(route('admin.journals.index')); ?>"
                    class="px-6 py-2.5 font-bold text-gray-600 hover:text-cisa-base hover:bg-gray-100 rounded-lg transition-colors">Cancel</a>
                <button type="submit"
                    class="px-8 py-2.5 bg-cisa-accent hover:bg-amber-600 text-white font-bold rounded-lg shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all">
                    <i class="fas fa-save mr-2"></i>Create Journal
                </button>
            </div>
        </form>
    </div>

    <?php $__env->startPush('scripts'); ?>
        <script>
            document.addEventListener('alpine:init', () => {
                const editors = [
                    'description', 'homepage_content', // Homepage
                    'vision', 'mission', 'aims_scope', 'publication_frequency', // About
                    'peer_review_process', 'open_access_policy', 'copyright_notice', // Info
                    'editor_in_chief', 'editorial_board_members', 'ethics_policy', // Editorial
                    'apc_policy', 'submission_guidelines', // APC
                    'call_for_papers' // CFP
                ];

                editors.forEach(id => {
                    const container = document.getElementById(id + '-editor');
                    if (container) {
                        const quill = new Quill(container, {
                            theme: 'snow',
                            modules: { toolbar: [['bold', 'italic', 'underline', 'strike'], [{ 'list': 'ordered' }, { 'list': 'bullet' }], [{ 'header': [1, 2, 3, false] }], ['link', 'clean']] }
                        });
                        const hiddenArea = document.getElementById(id);
                        if (hiddenArea && hiddenArea.value) {
                            quill.root.innerHTML = hiddenArea.value;
                        }
                        quill.on('text-change', () => {
                            hiddenArea.value = quill.root.innerHTML;
                        });
                    }
                });
            });
        </script>
        <style>
            [x-cloak] {
                display: none !important;
            }

            .no-scrollbar::-webkit-scrollbar {
                display: none;
            }

            .no-scrollbar {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }
        </style>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u857061584/domains/cisajournal.org/public_html/resources/views/admin/journals/create.blade.php ENDPATH**/ ?>