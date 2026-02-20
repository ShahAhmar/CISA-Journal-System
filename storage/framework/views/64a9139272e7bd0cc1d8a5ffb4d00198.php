<?php $__env->startSection('title', 'Edit Journal - CISA'); ?>
<?php $__env->startSection('page-title', 'Edit Journal'); ?>
<?php $__env->startSection('page-subtitle', 'Update journal settings: ' . $journal->name); ?>

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
        <form method="POST" action="<?php echo e(route('admin.journals.update', $journal)); ?>" enctype="multipart/form-data"
            id="journalForm">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <!-- Tabs Navigation -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6 sticky top-0 z-30">
                <div class="flex overflow-x-auto p-2 gap-1 no-scrollbar">
                    <button type="button" @click="activeTab = 'basic'"
                        :class="activeTab === 'basic' ? 'active font-bold' : 'text-gray-500 hover:text-cisa-base font-medium'"
                        class="tab-btn px-4 py-3 rounded-lg text-sm whitespace-nowrap flex items-center gap-2"><i
                            class="fas fa-cog"></i>Basic</button>
                    <button type="button" @click="activeTab = 'pages'"
                        :class="activeTab === 'pages' ? 'active font-bold' : 'text-gray-500 hover:text-cisa-base font-medium'"
                        class="tab-btn px-4 py-3 rounded-lg text-sm whitespace-nowrap flex items-center gap-2"><i
                            class="fas fa-sitemap"></i>Page Names</button>
                    <button type="button" @click="activeTab = 'homepage'"
                        :class="activeTab === 'homepage' ? 'active font-bold' : 'text-gray-500 hover:text-cisa-base font-medium'"
                        class="tab-btn px-4 py-3 rounded-lg text-sm whitespace-nowrap flex items-center gap-2"><i
                            class="fas fa-home"></i>Homepage</button>
                    <button type="button" @click="activeTab = 'about'"
                        :class="activeTab === 'about' ? 'active font-bold' : 'text-gray-500 hover:text-cisa-base font-medium'"
                        class="tab-btn px-4 py-3 rounded-lg text-sm whitespace-nowrap flex items-center gap-2"><i
                            class="fas fa-info-circle"></i>About</button>
                    <button type="button" @click="activeTab = 'info'"
                        :class="activeTab === 'info' ? 'active font-bold' : 'text-gray-500 hover:text-cisa-base font-medium'"
                        class="tab-btn px-4 py-3 rounded-lg text-sm whitespace-nowrap flex items-center gap-2"><i
                            class="fas fa-book-open"></i>Info</button>
                    <button type="button" @click="activeTab = 'editorial'"
                        :class="activeTab === 'editorial' ? 'active font-bold' : 'text-gray-500 hover:text-cisa-base font-medium'"
                        class="tab-btn px-4 py-3 rounded-lg text-sm whitespace-nowrap flex items-center gap-2"><i
                            class="fas fa-users"></i>Editorial</button>
                    <button type="button" @click="activeTab = 'apc'"
                        :class="activeTab === 'apc' ? 'active font-bold' : 'text-gray-500 hover:text-cisa-base font-medium'"
                        class="tab-btn px-4 py-3 rounded-lg text-sm whitespace-nowrap flex items-center gap-2"><i
                            class="fas fa-file-invoice-dollar"></i>APC</button>
                    <button type="button" @click="activeTab = 'cfp'"
                        :class="activeTab === 'cfp' ? 'active font-bold' : 'text-gray-500 hover:text-cisa-base font-medium'"
                        class="tab-btn px-4 py-3 rounded-lg text-sm whitespace-nowrap flex items-center gap-2"><i
                            class="fas fa-bullhorn"></i>CFP</button>
                    <button type="button" @click="activeTab = 'disciplines'"
                        :class="activeTab === 'disciplines' ? 'active font-bold' : 'text-gray-500 hover:text-cisa-base font-medium'"
                        class="tab-btn px-4 py-3 rounded-lg text-sm whitespace-nowrap flex items-center gap-2"><i
                            class="fas fa-layer-group"></i>Disciplines</button>
                    <button type="button" @click="activeTab = 'partnerships'"
                        :class="activeTab === 'partnerships' ? 'active font-bold' : 'text-gray-500 hover:text-cisa-base font-medium'"
                        class="tab-btn px-4 py-3 rounded-lg text-sm whitespace-nowrap flex items-center gap-2"><i
                            class="fas fa-handshake"></i>Partnerships</button>
                    <button type="button" @click="activeTab = 'contact'"
                        :class="activeTab === 'contact' ? 'active font-bold' : 'text-gray-500 hover:text-cisa-base font-medium'"
                        class="tab-btn px-4 py-3 rounded-lg text-sm whitespace-nowrap flex items-center gap-2"><i
                            class="fas fa-address-card"></i>Contact</button>
                </div>
            </div>

            <div class="space-y-6 pb-20">
                <!-- Tab 1: Basic Settings -->
                <div x-show="activeTab === 'basic'" class="space-y-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                        <h2 class="text-xl font-bold text-cisa-base font-serif mb-6 border-b pb-2">Basic Information</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold text-cisa-base mb-2">Journal Name <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="name" value="<?php echo e(old('name', $journal->name)); ?>" required
                                    class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">Initials</label>
                                <input type="text" name="journal_initials"
                                    value="<?php echo e(old('journal_initials', $journal->journal_initials)); ?>"
                                    class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">Abbreviation</label>
                                <input type="text" name="journal_abbreviation"
                                    value="<?php echo e(old('journal_abbreviation', $journal->journal_abbreviation)); ?>"
                                    class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">URL Slug</label>
                                <input type="text" name="slug" value="<?php echo e(old('slug', $journal->slug)); ?>"
                                    class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg font-mono text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">Website URL</label>
                                <input type="url" name="journal_url" value="<?php echo e(old('journal_url', $journal->journal_url)); ?>"
                                    class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">Impact Factor</label>
                                <input type="number" step="0.01" name="impact_factor"
                                    value="<?php echo e(old('impact_factor', $journal->impact_factor)); ?>" placeholder="e.g. 2.50"
                                    class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg">
                                <p class="mt-1 text-[10px] text-gray-400 font-bold uppercase tracking-widest leading-none">
                                    Sets the numerical value displayed on the portal.</p>
                            </div>
                            <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-8 pt-4">
                                <div class="p-6 border-2 border-dashed border-gray-200 rounded-xl text-center">
                                    <label class="block font-bold text-cisa-base mb-2">Journal Logo</label>
                                    <?php if($journal->logo): ?> <img src="<?php echo e(Storage::url($journal->logo)); ?>"
                                    class="h-16 mx-auto mb-4"> <?php endif; ?>
                                    <input type="file" name="logo" class="w-full text-sm text-gray-400">
                                </div>
                                <div class="p-6 border-2 border-dashed border-gray-200 rounded-xl text-center">
                                    <label class="block font-bold text-cisa-base mb-2">Cover Image</label>
                                    <?php if($journal->cover_image): ?> <img src="<?php echo e(Storage::url($journal->cover_image)); ?>"
                                    class="h-32 mx-auto mb-4 object-cover"> <?php endif; ?>
                                    <input type="file" name="cover_image" class="w-full text-sm text-gray-400">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab 2: Page Names -->
                <div x-show="activeTab === 'pages'" class="space-y-6" x-cloak>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                        <h2 class="text-xl font-bold text-cisa-base font-serif mb-6 border-b pb-2">Customize Page Names &
                            Navigation</h2>
                        <p class="mb-6 text-sm text-gray-500">Customize how pages appear in the navigation menu. Uncheck
                            'Enabled' to hide a page.</p>

                        <div class="space-y-4">
                            <?php $__currentLoopData = $journal->pageSettings->sortBy('display_order'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $setting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex items-center gap-4 p-4 border border-gray-100 rounded-lg bg-slate-50">
                                    <span
                                        class="bg-white px-2 py-1 rounded text-xs font-mono font-bold text-gray-400 w-12 text-center"><?php echo e($setting->page_key); ?></span>
                                    <div class="flex-grow grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="text-xs font-bold text-gray-500 block mb-1">Page Title (H1)</label>
                                            <input type="text" name="page_settings[<?php echo e($setting->id); ?>][page_title]"
                                                value="<?php echo e($setting->page_title); ?>"
                                                class="w-full px-3 py-2 border rounded text-sm">
                                        </div>
                                        <div>
                                            <label class="text-xs font-bold text-gray-500 block mb-1">Menu Label</label>
                                            <input type="text" name="page_settings[<?php echo e($setting->id); ?>][menu_label]"
                                                value="<?php echo e($setting->menu_label); ?>"
                                                class="w-full px-3 py-2 border rounded text-sm">
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <input type="hidden" name="page_settings[<?php echo e($setting->id); ?>][is_enabled]" value="0">
                                        <input type="checkbox" name="page_settings[<?php echo e($setting->id); ?>][is_enabled]" value="1" <?php echo e($setting->is_enabled ? 'checked' : ''); ?> class="w-5 h-5 text-cisa-accent rounded">
                                        <span class="text-sm font-medium">Enabled</span>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>

                <!-- Tab 3: Homepage -->
                <div x-show="activeTab === 'homepage'" class="space-y-6" x-cloak>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                        <h2 class="text-xl font-bold text-cisa-base font-serif mb-6 border-b pb-2">Homepage Content (Hero &
                            Intro)</h2>
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">Header Badge Text</label>
                                <input type="text" name="badge_text" value="<?php echo e(old('badge_text', $journal->badge_text)); ?>"
                                    placeholder="e.g. Peer Reviewed & Open Access"
                                    class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:border-cisa-accent outline-none">
                                <p class="mt-1 text-xs text-gray-400">This text appears in a gold badge in the journal
                                    header. Leave empty for default.</p>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">Description / Intro Text</label>
                                <div id="description-editor" class="quill-editor h-32"></div>
                                <textarea name="description" id="description"
                                    class="hidden"><?php echo e(old('description', $journal->description)); ?></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">Hero Section Content</label>
                                <div id="homepage_content-editor" class="quill-editor h-32"></div>
                                <textarea name="homepage_content" id="homepage_content"
                                    class="hidden"><?php echo e(old('homepage_content', $journal->homepage_content)); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab 4: About -->
                <div x-show="activeTab === 'about'" class="space-y-6" x-cloak>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                        <h2 class="text-xl font-bold text-cisa-base font-serif mb-6 border-b pb-2">About Page Content</h2>
                        <div class="space-y-8">
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">Vision Statement</label>
                                <div id="vision-editor" class="quill-editor h-32"></div>
                                <textarea name="vision" id="vision"
                                    class="hidden"><?php echo e(old('vision', $journal->vision)); ?></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">Mission Statement</label>
                                <div id="mission-editor" class="quill-editor h-32"></div>
                                <textarea name="mission" id="mission"
                                    class="hidden"><?php echo e(old('mission', $journal->mission)); ?></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">Aims & Scope</label>
                                <div id="aims_scope-editor" class="quill-editor h-48"></div>
                                <textarea name="aims_scope" id="aims_scope"
                                    class="hidden"><?php echo e(old('aims_scope', $journal->aims_scope)); ?></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">Publication Frequency</label>
                                <div id="publication_frequency-editor" class="quill-editor h-24"></div>
                                <textarea name="publication_frequency" id="publication_frequency"
                                    class="hidden"><?php echo e(old('publication_frequency', $journal->publication_frequency)); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab 5: Info -->
                <div x-show="activeTab === 'info'" class="space-y-6" x-cloak>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                        <h2 class="text-xl font-bold text-cisa-base font-serif mb-6 border-b pb-2">Journal Info Page</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">Print ISSN</label>
                                <input type="text" name="print_issn" value="<?php echo e(old('print_issn', $journal->print_issn)); ?>"
                                    class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg font-mono">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">Online ISSN</label>
                                <input type="text" name="online_issn"
                                    value="<?php echo e(old('online_issn', $journal->online_issn)); ?>"
                                    class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg font-mono">
                            </div>
                        </div>
                        <div class="space-y-8">
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">Peer Review Process</label>
                                <div id="peer_review_process-editor" class="quill-editor h-32"></div>
                                <textarea name="peer_review_process" id="peer_review_process"
                                    class="hidden"><?php echo e(old('peer_review_process', $journal->peer_review_process)); ?></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">Open Access Policy</label>
                                <div id="open_access_policy-editor" class="quill-editor h-32"></div>
                                <textarea name="open_access_policy" id="open_access_policy"
                                    class="hidden"><?php echo e(old('open_access_policy', $journal->open_access_policy)); ?></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">Copyright Notice</label>
                                <div id="copyright_notice-editor" class="quill-editor h-32"></div>
                                <textarea name="copyright_notice" id="copyright_notice"
                                    class="hidden"><?php echo e(old('copyright_notice', $journal->copyright_notice)); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab 6: Editorial -->
                <div x-show="activeTab === 'editorial'" class="space-y-6" x-cloak>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                        <h2 class="text-xl font-bold text-cisa-base font-serif mb-6 border-b pb-2">Editorial & Ethics Page
                        </h2>
                        <div class="space-y-8">
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">Editor-in-Chief</label>
                                <div id="editor_in_chief-editor" class="quill-editor h-32"></div>
                                <textarea name="editor_in_chief" id="editor_in_chief"
                                    class="hidden"><?php echo e(old('editor_in_chief', $journal->editor_in_chief)); ?></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">Editorial Board Members</label>
                                <div id="editorial_board_members-editor" class="quill-editor h-48"></div>
                                <textarea name="editorial_board_members" id="editorial_board_members"
                                    class="hidden"><?php echo e(old('editorial_board_members', $journal->editorial_board_members)); ?></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">Ethics Policy</label>
                                <div id="ethics_policy-editor" class="quill-editor h-48"></div>
                                <textarea name="ethics_policy" id="ethics_policy"
                                    class="hidden"><?php echo e(old('ethics_policy', $journal->ethics_policy)); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab 7: APC -->
                <div x-show="activeTab === 'apc'" class="space-y-6" x-cloak>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                        <h2 class="text-xl font-bold text-cisa-base font-serif mb-6 border-b pb-2">APC & Submission Page
                        </h2>
                        <div class="space-y-8">
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">APC Policy</label>
                                <div id="apc_policy-editor" class="quill-editor h-32"></div>
                                <textarea name="apc_policy" id="apc_policy"
                                    class="hidden"><?php echo e(old('apc_policy', $journal->apc_policy)); ?></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">Submission Guidelines</label>
                                <div id="submission_guidelines-editor" class="quill-editor h-48"></div>
                                <textarea name="submission_guidelines" id="submission_guidelines"
                                    class="hidden"><?php echo e(old('submission_guidelines', $journal->submission_guidelines)); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab 8: CFP -->
                <div x-show="activeTab === 'cfp'" class="space-y-6" x-cloak>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                        <h2 class="text-xl font-bold text-cisa-base font-serif mb-6 border-b pb-2">Call for Papers Page</h2>
                        <div>
                            <label class="block text-sm font-bold text-cisa-base mb-2">Call for Papers Content</label>
                            <div id="call_for_papers-editor" class="quill-editor h-64"></div>
                            <textarea name="call_for_papers" id="call_for_papers"
                                class="hidden"><?php echo e(old('call_for_papers', $journal->call_for_papers)); ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- Tab 9: Partnerships -->
                <div x-show="activeTab === 'partnerships'" class="space-y-6" x-cloak>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                        <h2 class="text-xl font-bold text-cisa-base font-serif mb-6 border-b pb-2">Partnerships Page Content
                        </h2>
                        <div>
                            <label class="block text-sm font-bold text-cisa-base mb-2">Partnerships Content</label>
                            <div id="partnerships_content-editor" class="quill-editor h-64"></div>
                            <textarea name="partnerships_content" id="partnerships_content"
                                class="hidden"><?php echo e(old('partnerships_content', $journal->partnerships_content)); ?></textarea>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8"
                        x-data="{ partners: <?php echo e($journal->partners->count() > 0 ? $journal->partners->map(function ($p) {
        return ['id' => $p->id, 'name' => $p->name, 'website_url' => $p->website_url, 'logo_url' => asset('storage/' . $p->logo)]; })->toJson() : '[]'); ?> }">
                        <div class="flex items-center justify-between mb-6 border-b pb-2">
                            <h2 class="text-xl font-bold text-cisa-base font-serif">Partner Logos</h2>
                            <button type="button"
                                @click="partners.push({id: null, name: '', website_url: '', logo_url: null})"
                                class="text-sm bg-cisa-accent text-white px-3 py-1 rounded hover:bg-amber-600 transition-colors">
                                + Add Partner
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <template x-for="(partner, index) in partners" :key="index">
                                <div class="bg-slate-50 p-4 rounded-xl border border-gray-200 relative group">
                                    <button type="button" @click="partners = partners.filter((_, i) => i !== index)"
                                        class="absolute top-2 right-2 text-red-500 hover:text-red-700 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <i class="fas fa-times-circle"></i>
                                    </button>

                                    <input type="hidden" :name="'partners['+index+'][id]'" :value="partner.id">

                                    <div class="flex gap-4">
                                        <div class="shrink-0">
                                            <div
                                                class="w-20 h-20 bg-white border border-gray-200 rounded-lg overflow-hidden flex items-center justify-center relative">
                                                <template x-if="partner.logo_url">
                                                    <img :src="partner.logo_url"
                                                        class="max-w-full max-h-full object-contain">
                                                </template>
                                                <template x-if="!partner.logo_url">
                                                    <i class="fas fa-image text-gray-300 text-2xl"></i>
                                                </template>
                                            </div>
                                            <div class="mt-2 text-center">
                                                <label :for="'logo_'+index"
                                                    class="cursor-pointer text-[10px] bg-slate-200 px-2 py-1 rounded hover:bg-slate-300 transition-colors">Change</label>
                                                <input type="file" :id="'logo_'+index" :name="'partners['+index+'][logo]'"
                                                    class="hidden"
                                                    @change="const file = $event.target.files[0]; if(file) partner.logo_url = URL.createObjectURL(file)">
                                            </div>
                                        </div>
                                        <div class="flex-grow space-y-2">
                                            <div>
                                                <label class="text-[10px] font-bold text-gray-400 uppercase">Partner
                                                    Name</label>
                                                <input type="text" :name="'partners['+index+'][name]'"
                                                    x-model="partner.name" placeholder="e.g. University of Lagos"
                                                    class="w-full px-3 py-2 text-sm bg-white border border-gray-200 rounded-lg focus:border-cisa-accent outline-none">
                                            </div>
                                            <div>
                                                <label class="text-[10px] font-bold text-gray-400 uppercase">Website
                                                    URL</label>
                                                <input type="text" :name="'partners['+index+'][website_url]'"
                                                    x-model="partner.website_url" placeholder="https://..."
                                                    class="w-full px-3 py-2 text-sm bg-white border border-gray-200 rounded-lg focus:border-cisa-accent outline-none">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div x-show="partners.length === 0"
                            class="text-center py-12 bg-slate-50 rounded-xl border-2 border-dashed border-gray-200 text-gray-400">
                            <i class="fas fa-handshake text-4xl mb-3 opacity-20"></i>
                            <p>No partner logos added yet. Click "+ Add Partner" to begin.</p>
                        </div>
                    </div>
                </div>

                <!-- Tab 10: Disciplines -->
                <div x-show="activeTab === 'disciplines'" class="space-y-6"
                    x-data="{ items: <?php echo e($journal->disciplines->count() > 0 ? $journal->disciplines->toJson() : '[]'); ?> }"
                    x-cloak>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                        <div class="flex items-center justify-between mb-6 border-b pb-2">
                            <h2 class="text-xl font-bold text-cisa-base font-serif">Journal Disciplines</h2>
                            <button type="button" @click="items.push({id: null, name: ''})"
                                class="text-sm bg-cisa-accent text-white px-3 py-1 rounded hover:bg-amber-600 transition-colors">
                                + Add Discipline
                            </button>
                        </div>
                        <p class="mb-6 text-sm text-gray-500">Add disciplines to allow filtering on the Publications page.
                        </p>

                        <div class="space-y-3">
                            <template x-for="(item, index) in items" :key="index">
                                <div class="flex items-center gap-3">
                                    <input type="hidden" :name="'disciplines['+index+'][id]'" :value="item.id">
                                    <input type="text" :name="'disciplines['+index+'][name]'" x-model="item.name"
                                        placeholder="Discipline Name (e.g. Accounting)"
                                        class="flex-grow px-4 py-2 bg-slate-50 border border-gray-200 rounded-lg">
                                    <button type="button" @click="items = items.filter((_, i) => i !== index)"
                                        class="text-red-500 hover:text-red-700">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </template>
                            <div x-show="items.length === 0" class="text-center py-8 bg-slate-50 rounded-lg text-gray-400">
                                No disciplines added yet.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab 10: Contact -->
                <div x-show="activeTab === 'contact'" class="space-y-6" x-cloak>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                        <h2 class="text-xl font-bold text-cisa-base font-serif mb-6 border-b pb-2">Contact Page & Footer
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">Primary Contact Name</label>
                                <input type="text" name="primary_contact_name"
                                    value="<?php echo e(old('primary_contact_name', $journal->primary_contact_name)); ?>"
                                    class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-cisa-base mb-2">Primary Contact Email</label>
                                <input type="email" name="primary_contact_email"
                                    value="<?php echo e(old('primary_contact_email', $journal->primary_contact_email)); ?>"
                                    class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold text-cisa-base mb-2">Mailing Address</label>
                                <textarea name="contact_address" rows="4"
                                    class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg"><?php echo e(old('contact_address', $journal->contact_address)); ?></textarea>
                            </div>
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
                    <i class="fas fa-save mr-2"></i>Update Journal
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
                    'call_for_papers', // CFP
                    'partnerships_content' // Partnerships
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
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u857061584/domains/cisajournal.org/public_html/resources/views/admin/journals/edit.blade.php ENDPATH**/ ?>