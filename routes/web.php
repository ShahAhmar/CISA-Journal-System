<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\Author\SubmissionController as AuthorSubmissionController;
use App\Http\Controllers\Editor\EditorController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\JournalController as AdminJournalController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

// Public Routes
Route::get('/', function () {
    return redirect()->route('journals.index');
});

// Quick fix route - Remove after use
Route::get('/fix-email-name', function () {
    if (Schema::hasTable('email_settings')) {
        DB::table('email_settings')->update(['mail_from_name' => 'EMANP']);
        Config::set('mail.from.name', 'EMANP');
        return 'Email name fixed to EMANP! <a href="/">Go Home</a>';
    }
    return 'No email_settings table found';
})->middleware('web');

// OAI-PMH Endpoint for Indexing
Route::get('/oai-pmh', [\App\Http\Controllers\OAIPMHController::class, 'index'])->name('oai-pmh.index');

Route::get('/search', [\App\Http\Controllers\SearchController::class, 'search'])->name('search');
Route::get('/search/advanced', [\App\Http\Controllers\AdvancedSearchController::class, 'search'])->name('search.advanced');
Route::get('/search/fulltext', [\App\Http\Controllers\AdvancedSearchController::class, 'fullTextSearch'])->name('search.fulltext');

// Language switcher
Route::get('/language/switch', [\App\Http\Controllers\LanguageController::class, 'switch'])->name('language.switch');
Route::get('/language/current', [\App\Http\Controllers\LanguageController::class, 'current'])->name('language.current');

// RSS Feeds
Route::get('/journal/{journal:slug}/rss', [\App\Http\Controllers\RSSFeedController::class, 'journal'])->name('journals.rss');
Route::get('/journal/{journal:slug}/issue/{issue}/rss', [\App\Http\Controllers\RSSFeedController::class, 'issue'])->name('journals.issue.rss');

Route::get('/publish-with-us', [\App\Http\Controllers\PublishController::class, 'index'])->name('publish.index');

Route::get('/journals', [JournalController::class, 'index'])->name('journals.index');
Route::get('/journal/{journal:slug}', [JournalController::class, 'show'])->name('journals.show');
Route::get('/journal/{journal:slug}/search', [JournalController::class, 'search'])->name('journals.search');
Route::get('/journal/{journal:slug}/aims-scope', [JournalController::class, 'aimsScope'])->name('journals.aims-scope');
Route::get('/journal/{journal:slug}/editorial-board', [JournalController::class, 'editorialBoard'])->name('journals.editorial-board');
Route::get('/journal/{journal:slug}/submission-guidelines', [JournalController::class, 'submissionGuidelines'])->name('journals.submission-guidelines');
Route::get('/journal/{journal:slug}/peer-review-policy', [JournalController::class, 'peerReviewPolicy'])->name('journals.peer-review-policy');
Route::get('/journal/{journal:slug}/open-access-policy', [JournalController::class, 'openAccessPolicy'])->name('journals.open-access-policy');
Route::get('/journal/{journal:slug}/copyright-notice', [JournalController::class, 'copyrightNotice'])->name('journals.copyright-notice');
Route::get('/journal/{journal:slug}/contact', [JournalController::class, 'contact'])->name('journals.contact');
Route::get('/journal/{journal:slug}/issues', [JournalController::class, 'issues'])->name('journals.issues');
Route::get('/journal/{journal:slug}/archives', [JournalController::class, 'archives'])->name('journals.archives');
Route::get('/journal/{journal:slug}/issue/{issue}', [JournalController::class, 'showIssue'])->name('journals.issue');
Route::get('/journal/{journal:slug}/article/{submission}', [JournalController::class, 'showArticle'])->name('journals.article');
Route::get('/journal/{journal:slug}/author-guidelines', [JournalController::class, 'authorGuidelines'])->name('journals.author-guidelines');
Route::get('/journal/{journal:slug}/announcements', [JournalController::class, 'announcements'])->name('journals.announcements');
Route::get('/journal/{journal:slug}/history', [JournalController::class, 'history'])->name('journals.history');
Route::get('/journal/{journal:slug}/editorial-policies', [JournalController::class, 'editorialPolicies'])->name('journals.editorial-policies');
Route::get('/journal/{journal:slug}/page/{page:slug}', [JournalController::class, 'customPage'])->name('journals.custom-page');
Route::get('/journal/{journal:slug}/article/{submission}/download', [JournalController::class, 'downloadArticle'])->name('journals.article.download');

// Citation Manager
Route::get('/article/{submission}/citation/zotero', [\App\Http\Controllers\CitationManagerController::class, 'exportZotero'])->name('citation.zotero');
Route::get('/article/{submission}/citation/mendeley', [\App\Http\Controllers\CitationManagerController::class, 'exportMendeley'])->name('citation.mendeley');
Route::get('/article/{submission}/citation/endnote', [\App\Http\Controllers\CitationManagerController::class, 'exportEndNote'])->name('citation.endnote');
Route::get('/article/{submission}/citation', [\App\Http\Controllers\CitationManagerController::class, 'citation'])->name('citation.format');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Password Reset Routes
    Route::get('/forgot-password', [\App\Http\Controllers\ForgotPasswordController::class, 'show'])->name('password.request');
    Route::post('/forgot-password', [\App\Http\Controllers\ForgotPasswordController::class, 'send'])->name('password.email');
    Route::get('/reset-password/{token}', [\App\Http\Controllers\ResetPasswordController::class, 'show'])->name('password.reset');
    Route::post('/reset-password', [\App\Http\Controllers\ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ORCID Integration
    Route::get('/orcid/redirect', [\App\Http\Controllers\ORCIDController::class, 'redirect'])->name('orcid.redirect');
    Route::get('/orcid/callback', [\App\Http\Controllers\ORCIDController::class, 'callback'])->name('orcid.callback');
    Route::post('/orcid/unlink', [\App\Http\Controllers\ORCIDController::class, 'unlink'])->name('orcid.unlink');

    // Profile
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('show');
        Route::post('/identity', [ProfileController::class, 'updateIdentity'])->name('update.identity');
        Route::post('/contact', [ProfileController::class, 'updateContact'])->name('update.contact');
        Route::post('/public', [ProfileController::class, 'updatePublic'])->name('update.public');
        Route::post('/password', [ProfileController::class, 'updatePassword'])->name('update.password');
        Route::post('/roles', [ProfileController::class, 'updateRoles'])->name('update.roles');
        Route::post('/notifications', [ProfileController::class, 'updateNotifications'])->name('update.notifications');
    });

    // Payment Routes
    Route::prefix('payment')->name('payment.')->group(function () {
        Route::get('/journal/{journal}/{type}', [\App\Http\Controllers\Payment\PaymentController::class, 'show'])->name('show');
        Route::get('/journal/{journal}/{type}/submission/{submission}', [\App\Http\Controllers\Payment\PaymentController::class, 'show'])->name('show.submission');
        Route::post('/{payment}/process', [\App\Http\Controllers\Payment\PaymentController::class, 'process'])->name('process');
        Route::get('/{payment}/success', [\App\Http\Controllers\Payment\PaymentController::class, 'success'])->name('success');
        Route::get('/{payment}/cancel', [\App\Http\Controllers\Payment\PaymentController::class, 'cancel'])->name('cancel');
        Route::post('/webhook/{gateway}', [\App\Http\Controllers\Payment\PaymentController::class, 'webhook'])->name('webhook');
    });

    // Author Routes
    Route::prefix('author')->name('author.')->group(function () {
        Route::get('/submissions', [AuthorSubmissionController::class, 'index'])->name('submissions.index');
        Route::get('/journal/{journal:slug}/submit', [AuthorSubmissionController::class, 'create'])->name('submissions.create');
        Route::post('/journal/{journal:slug}/submit', [AuthorSubmissionController::class, 'store'])->name('submissions.store');
        Route::get('/submissions/{submission}/success', [AuthorSubmissionController::class, 'success'])->name('submissions.success');
        Route::get('/submissions/{submission}', [AuthorSubmissionController::class, 'show'])->name('submissions.show');
        Route::get('/submissions/{submission}/revision', [AuthorSubmissionController::class, 'edit'])->name('submissions.edit');
        Route::post('/submissions/{submission}/revision', [AuthorSubmissionController::class, 'uploadRevision'])->name('submissions.upload-revision');
        // Withdraw: support GET (redirect to detail) and POST (perform)
        Route::get('/submissions/{submission}/withdraw', [AuthorSubmissionController::class, 'withdrawForm'])->name('submissions.withdraw.form');
        Route::post('/submissions/{submission}/withdraw', [AuthorSubmissionController::class, 'withdraw'])->name('submissions.withdraw');
        Route::post('/submissions/{submission}/copyedit/approve', [\App\Http\Controllers\Author\CopyeditApprovalController::class, 'approve'])->name('submissions.copyedit.approve');
        Route::post('/submissions/{submission}/copyedit/request-changes', [\App\Http\Controllers\Author\CopyeditApprovalController::class, 'requestChanges'])->name('submissions.copyedit.request-changes');
    });

    // Discussion Thread Routes
    Route::prefix('submissions/{submission}/discussions')->name('discussions.')->group(function () {
        Route::post('/threads', [\App\Http\Controllers\DiscussionThreadController::class, 'store'])->name('threads.store');
        Route::post('/threads/{thread}/comments', [\App\Http\Controllers\DiscussionThreadController::class, 'addComment'])->name('comments.store');
        Route::post('/threads/{thread}/toggle-lock', [\App\Http\Controllers\DiscussionThreadController::class, 'toggleLock'])->name('threads.toggle-lock');
    });

    // Editor Routes
    Route::prefix('editor')->name('editor.')->group(function () {
        Route::get('/journal/{journal:slug}/dashboard', [EditorController::class, 'dashboard'])->name('dashboard');
        Route::get('/journal/{journal:slug}/submissions', [EditorController::class, 'submissions'])->name('submissions.index');
        Route::get('/journal/{journal:slug}/submissions/{submission}', [EditorController::class, 'showSubmission'])->name('submissions.show');
        // Contact Author (fallback without slug, allow GET/POST to avoid 404 redirects)
        Route::match(['get', 'post'], '/submissions/{submission}/contact-author', [EditorController::class, 'contactAuthor'])->name('submissions.contact-author.no-slug');
        // Accept submission (fallback without slug; GET will redirect back to submission)
        Route::match(['get', 'post'], '/submissions/{submission}/accept', [EditorController::class, 'acceptSubmission'])->name('submissions.accept.no-slug');
        // Publish submission (fallback without slug; GET will redirect back to submission)
        Route::match(['get', 'post'], '/submissions/{submission}/publish', [EditorController::class, 'publishSubmission'])->name('submissions.publish.no-slug');
        Route::post('/journal/{journal:slug}/submissions/{submission}/assign-editor', [EditorController::class, 'assignEditor'])->name('submissions.assign-editor');
        Route::post('/journal/{journal:slug}/submissions/{submission}/assign-reviewer', [EditorController::class, 'assignReviewer'])->name('submissions.assign-reviewer');
        Route::match(['get', 'post'], '/journal/{journal:slug}/submissions/{submission}/accept', [EditorController::class, 'acceptSubmission'])->name('submissions.accept');
        Route::post('/journal/{journal:slug}/submissions/{submission}/reject', [EditorController::class, 'rejectSubmission'])->name('submissions.reject');
        Route::post('/journal/{journal:slug}/submissions/{submission}/desk-reject', [EditorController::class, 'deskReject'])->name('submissions.desk-reject');
        Route::post('/journal/{journal:slug}/submissions/{submission}/request-revision', [EditorController::class, 'requestRevision'])->name('submissions.request-revision');
        Route::match(['get', 'post'], '/journal/{journal:slug}/submissions/{submission}/publish', [EditorController::class, 'publishSubmission'])->name('submissions.publish');
        Route::post('/journal/{journal:slug}/submissions/{submission}/contact-author', [EditorController::class, 'contactAuthor'])->name('submissions.contact-author');
        Route::post('/journal/{journal:slug}/submissions/{submission}/copyedit/final-approve', [EditorController::class, 'finalApproveCopyedit'])->name('submissions.copyedit.final-approve');

        // Crossref Integration
        Route::post('/journal/{journal:slug}/submissions/{submission}/crossref/register', [\App\Http\Controllers\CrossrefController::class, 'registerDOI'])->name('submissions.crossref.register');
        Route::post('/journal/{journal:slug}/submissions/{submission}/crossref/generate', [\App\Http\Controllers\CrossrefController::class, 'generateDOI'])->name('submissions.crossref.generate');
        Route::get('/journal/{journal:slug}/submissions/{submission}/crossref/check', [\App\Http\Controllers\CrossrefController::class, 'checkDOI'])->name('submissions.crossref.check');
    });

    // Production/Galley Routes
    Route::prefix('production')->name('production.')->group(function () {
        Route::post('/submissions/{submission}/galleys/upload', [\App\Http\Controllers\Production\GalleyController::class, 'upload'])->name('galleys.upload');
        Route::post('/galleys/{galley}/approve', [\App\Http\Controllers\Production\GalleyController::class, 'approve'])->name('galleys.approve');
        Route::post('/galleys/{galley}/request-changes', [\App\Http\Controllers\Production\GalleyController::class, 'requestChanges'])->name('galleys.request-changes');
        Route::post('/submissions/{submission}/final-publish', [\App\Http\Controllers\Production\GalleyController::class, 'finalPublish'])->name('submissions.final-publish');
    });

    // Copyeditor Routes
    Route::prefix('copyeditor')->name('copyeditor.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\CopyeditorController::class, 'dashboard'])->name('dashboard');
        Route::get('/submissions/{submission}', [\App\Http\Controllers\CopyeditorController::class, 'show'])->name('submissions.show');
        Route::post('/submissions/{submission}/upload', [\App\Http\Controllers\CopyeditorController::class, 'uploadCopyeditedFile'])->name('submissions.upload');
    });

    // Proofreader Routes
    Route::prefix('proofreader')->name('proofreader.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\ProofreaderController::class, 'dashboard'])->name('dashboard');
        Route::get('/submissions/{submission}', [\App\Http\Controllers\ProofreaderController::class, 'show'])->name('submissions.show');
        Route::post('/submissions/{submission}/upload', [\App\Http\Controllers\ProofreaderController::class, 'uploadProofreadFile'])->name('submissions.upload');
    });

    // Layout Editor Routes
    Route::prefix('layout-editor')->name('layout-editor.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\LayoutEditorController::class, 'dashboard'])->name('dashboard');
        Route::get('/submissions/{submission}', [\App\Http\Controllers\LayoutEditorController::class, 'show'])->name('submissions.show');
        Route::post('/submissions/{submission}/upload', [\App\Http\Controllers\LayoutEditorController::class, 'uploadLayout'])->name('submissions.upload');
        Route::post('/submissions/{submission}/complete', [\App\Http\Controllers\LayoutEditorController::class, 'completeLayout'])->name('submissions.complete');
    });

    // Reviewer Routes
    Route::prefix('reviewer')->name('reviewer.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\ReviewerController::class, 'dashboard'])->name('dashboard');
        Route::get('/review/{review}/initial', [\App\Http\Controllers\ReviewerController::class, 'showInitialReview'])->name('initial-review.show');
        Route::post('/review/{review}/accept', [\App\Http\Controllers\ReviewerController::class, 'acceptReview'])->name('review.accept');
        Route::post('/review/{review}/decline', [\App\Http\Controllers\ReviewerController::class, 'declineReview'])->name('review.decline');
        Route::get('/review/{review}', [\App\Http\Controllers\ReviewerController::class, 'showReview'])->name('review.show');
        Route::post('/review/{review}/submit', [\App\Http\Controllers\ReviewerController::class, 'submitReview'])->name('review.submit');
        Route::get('/review/{review}/file/{file}/download', [\App\Http\Controllers\ReviewerController::class, 'downloadFile'])->name('file.download');
        Route::get('/review/{review}/details', [\App\Http\Controllers\ReviewerController::class, 'getSubmissionDetails'])->name('review.details');
    });

    // Admin Routes
    Route::prefix('admin')->name('admin.')->middleware('can:access-admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('journals', AdminJournalController::class);
        Route::resource('submissions', \App\Http\Controllers\Admin\SubmissionController::class);
        Route::post('submissions/{submission}/approve', [\App\Http\Controllers\Admin\SubmissionController::class, 'approve'])->name('submissions.approve');
        Route::post('submissions/{submission}/reject', [\App\Http\Controllers\Admin\SubmissionController::class, 'reject'])->name('submissions.reject');
        Route::post('submissions/{submission}/assign-reviewer', [\App\Http\Controllers\Admin\SubmissionController::class, 'assignReviewer'])->name('submissions.assign-reviewer');
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        Route::post('users/{user}/assign-journal-role', [\App\Http\Controllers\Admin\UserController::class, 'assignJournalRole'])->name('users.assign-journal-role');
        Route::delete('users/{user}/journal/{journal}/role/{role}', [\App\Http\Controllers\Admin\UserController::class, 'removeJournalRole'])->name('users.remove-journal-role');
        Route::resource('issues', \App\Http\Controllers\Admin\IssueController::class);
        Route::post('issues/{issue}/unpublish', [\App\Http\Controllers\Admin\IssueController::class, 'unpublish'])->name('issues.unpublish');
        Route::post('issues/{issue}/republish', [\App\Http\Controllers\Admin\IssueController::class, 'republish'])->name('issues.republish');

        // Sections Management
        Route::prefix('journal/{journal}/sections')->name('sections.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\SectionController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Admin\SectionController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Admin\SectionController::class, 'store'])->name('store');
            Route::get('/{section}/edit', [\App\Http\Controllers\Admin\SectionController::class, 'edit'])->name('edit');
            Route::put('/{section}', [\App\Http\Controllers\Admin\SectionController::class, 'update'])->name('update');
            Route::delete('/{section}', [\App\Http\Controllers\Admin\SectionController::class, 'destroy'])->name('destroy');
        });

        // Reviews Management
        Route::prefix('reviews')->name('reviews.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('index');
            Route::get('/{review}', [\App\Http\Controllers\Admin\ReviewController::class, 'show'])->name('show');
            Route::put('/{review}', [\App\Http\Controllers\Admin\ReviewController::class, 'update'])->name('update');
        });
        Route::get('/editorial-workflows', [\App\Http\Controllers\Admin\EditorialWorkflowController::class, 'index'])->name('editorial-workflows.index');
        Route::get('/announcements', [\App\Http\Controllers\Admin\AnnouncementController::class, 'index'])->name('announcements.index');
        Route::get('/announcements/create', [\App\Http\Controllers\Admin\AnnouncementController::class, 'create'])->name('announcements.create');
        Route::post('/announcements', [\App\Http\Controllers\Admin\AnnouncementController::class, 'store'])->name('announcements.store');
        Route::get('/announcements/{announcement}/edit', [\App\Http\Controllers\Admin\AnnouncementController::class, 'edit'])->name('announcements.edit');
        Route::put('/announcements/{announcement}', [\App\Http\Controllers\Admin\AnnouncementController::class, 'update'])->name('announcements.update');
        Route::delete('/announcements/{announcement}', [\App\Http\Controllers\Admin\AnnouncementController::class, 'destroy'])->name('announcements.destroy');
        Route::post('/announcements/{announcement}/resend-emails', [\App\Http\Controllers\Admin\AnnouncementController::class, 'resendEmails'])->name('announcements.resend-emails');
        Route::get('/website-settings', [\App\Http\Controllers\Admin\WebsiteSettingsController::class, 'index'])->name('website-settings.index');
        Route::post('/website-settings', [\App\Http\Controllers\Admin\WebsiteSettingsController::class, 'update'])->name('website-settings.update');
        Route::prefix('email-templates')->name('email-templates.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\EmailTemplateController::class, 'index'])->name('index');
            Route::get('/{templateKey}/edit', [\App\Http\Controllers\Admin\EmailTemplateController::class, 'edit'])->name('edit');
            Route::put('/{templateKey}', [\App\Http\Controllers\Admin\EmailTemplateController::class, 'update'])->name('update');
        });
        Route::prefix('system-settings')->name('system-settings.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'index'])->name('index');
            Route::post('/update-smtp', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'updateSmtp'])->name('update-smtp');
            Route::post('/test-email', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'testEmail'])->name('test-email');
        });

        // Analytics Routes
        Route::prefix('analytics')->name('analytics.')->group(function () {
            Route::get('/', [\App\Http\Controllers\AnalyticsController::class, 'dashboard'])->name('dashboard');
            Route::get('/article/{submission}', [\App\Http\Controllers\AnalyticsController::class, 'article'])->name('article');
            Route::get('/journal/{journal}', [\App\Http\Controllers\AnalyticsController::class, 'journal'])->name('journal');
            Route::get('/advanced', [\App\Http\Controllers\AnalyticsController::class, 'advancedStats'])->name('advanced');
            Route::get('/advanced/journal/{journal}', [\App\Http\Controllers\AnalyticsController::class, 'advancedStats'])->name('advanced.journal');
        });

        // Enhanced Statistics
        Route::prefix('statistics')->name('statistics.')->group(function () {
            Route::get('/enhanced', [\App\Http\Controllers\Admin\EnhancedStatisticsController::class, 'index'])->name('enhanced');
            Route::get('/export/pdf', [\App\Http\Controllers\Admin\EnhancedStatisticsController::class, 'exportPDF'])->name('export.pdf');
            Route::get('/export/excel', [\App\Http\Controllers\Admin\EnhancedStatisticsController::class, 'exportExcel'])->name('export.excel');
        });

        // Review Forms Management
        Route::resource('review-forms', \App\Http\Controllers\Admin\ReviewFormController::class);

        // Subscription Management
        Route::resource('subscriptions', \App\Http\Controllers\Admin\SubscriptionController::class);

        // Language Management
        Route::prefix('languages')->name('languages.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\LanguageController::class, 'index'])->name('index');
            Route::post('/set-default', [\App\Http\Controllers\Admin\LanguageController::class, 'setDefault'])->name('set-default');
        });

        // Plugin Management
        Route::prefix('plugins')->name('plugins.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\PluginController::class, 'index'])->name('index');
            Route::post('/install', [\App\Http\Controllers\Admin\PluginController::class, 'install'])->name('install');
            Route::post('/{name}/uninstall', [\App\Http\Controllers\Admin\PluginController::class, 'uninstall'])->name('uninstall');
            Route::post('/{name}/activate', [\App\Http\Controllers\Admin\PluginController::class, 'activate'])->name('activate');
            Route::post('/{name}/deactivate', [\App\Http\Controllers\Admin\PluginController::class, 'deactivate'])->name('deactivate');
        });

        // Payments Routes
        Route::prefix('payments')->name('payments.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Admin\PaymentController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Admin\PaymentController::class, 'store'])->name('store');
            Route::get('/{payment}', [\App\Http\Controllers\Admin\PaymentController::class, 'show'])->name('show');
            Route::put('/{payment}', [\App\Http\Controllers\Admin\PaymentController::class, 'update'])->name('update');
            Route::put('/{payment}/status', [\App\Http\Controllers\Admin\PaymentController::class, 'updateStatus'])->name('update-status');
        });

        // Metadata Export Routes
        Route::prefix('export')->name('export.')->group(function () {
            Route::get('/submission/{submission}/ris', [\App\Http\Controllers\Export\MetadataExportController::class, 'exportRIS'])->name('ris');
            Route::get('/submission/{submission}/bibtex', [\App\Http\Controllers\Export\MetadataExportController::class, 'exportBibTeX'])->name('bibtex');
            Route::get('/submission/{submission}/xml', [\App\Http\Controllers\Export\MetadataExportController::class, 'exportXML'])->name('xml');
        });

        // Page Builder Routes (Global/Admin)
        Route::prefix('page-builder')->name('page-builder.')->group(function () {
            Route::get('/pages', [\App\Http\Controllers\Admin\PageBuilderController::class, 'pagesIndex'])->name('pages.index');
            Route::get('/pages/create', [\App\Http\Controllers\Admin\PageBuilderController::class, 'pagesCreate'])->name('pages.create');
            Route::post('/pages', [\App\Http\Controllers\Admin\PageBuilderController::class, 'pagesStore'])->name('pages.store');
            Route::get('/pages/{page}/edit', [\App\Http\Controllers\Admin\PageBuilderController::class, 'pagesEdit'])->name('pages.edit');
            Route::put('/pages/{page}', [\App\Http\Controllers\Admin\PageBuilderController::class, 'pagesUpdate'])->name('pages.update');
            Route::delete('/pages/{page}', [\App\Http\Controllers\Admin\PageBuilderController::class, 'pagesDestroy'])->name('pages.destroy');

            Route::get('/widgets', [\App\Http\Controllers\Admin\PageBuilderController::class, 'widgetsIndex'])->name('widgets.index');
            Route::get('/widgets/create', [\App\Http\Controllers\Admin\PageBuilderController::class, 'widgetsCreate'])->name('widgets.create');
            Route::post('/widgets', [\App\Http\Controllers\Admin\PageBuilderController::class, 'widgetsStore'])->name('widgets.store');
            Route::get('/widgets/{widget}', [\App\Http\Controllers\Admin\PageBuilderController::class, 'widgetsShow'])->name('widgets.show');
            Route::get('/widgets/{widget}/edit', [\App\Http\Controllers\Admin\PageBuilderController::class, 'widgetsEdit'])->name('widgets.edit');
            Route::put('/widgets/{widget}', [\App\Http\Controllers\Admin\PageBuilderController::class, 'widgetsUpdate'])->name('widgets.update');
            Route::delete('/widgets/{widget}', [\App\Http\Controllers\Admin\PageBuilderController::class, 'widgetsDestroy'])->name('widgets.destroy');
        });

        // Journal Pages Management (WordPress-style)
        Route::prefix('journal-pages')->name('journal-pages.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\JournalPagesController::class, 'index'])->name('index');
            Route::get('/journal/{journal}/{pageType}/edit', [\App\Http\Controllers\Admin\JournalPagesController::class, 'edit'])->name('edit');
            Route::put('/journal/{journal}/{pageType}', [\App\Http\Controllers\Admin\JournalPagesController::class, 'update'])->name('update');
        });

        // Journal-specific Page Builder
        Route::prefix('journal/{journal}')->name('journal.')->group(function () {
            Route::get('/page-builder/homepage', [\App\Http\Controllers\Admin\PageBuilderController::class, 'homepageBuilder'])->name('page-builder.homepage');
            Route::post('/page-builder/homepage/save', [\App\Http\Controllers\Admin\PageBuilderController::class, 'saveHomepageLayout'])->name('page-builder.save');
            Route::get('/page-builder/pages', [\App\Http\Controllers\Admin\PageBuilderController::class, 'pagesIndex'])->name('page-builder.pages.index');
            Route::get('/page-builder/pages/create', [\App\Http\Controllers\Admin\PageBuilderController::class, 'pagesCreate'])->name('page-builder.pages.create');
            Route::post('/page-builder/pages', [\App\Http\Controllers\Admin\PageBuilderController::class, 'pagesStore'])->name('page-builder.pages.store');
            Route::get('/page-builder/widgets', [\App\Http\Controllers\Admin\PageBuilderController::class, 'widgetsIndex'])->name('page-builder.widgets.index');
            Route::get('/page-builder/widgets/create', [\App\Http\Controllers\Admin\PageBuilderController::class, 'widgetsCreate'])->name('page-builder.widgets.create');
        });
    });
    Route::get('/partnership', [JournalController::class, 'partnership'])->name('partnership');
    Route::get('/plagiarism-check', [\App\Http\Controllers\PlagiarismController::class, 'index'])->name('plagiarism.index');
    Route::post('/plagiarism-check/process', [\App\Http\Controllers\PlagiarismController::class, 'process'])->name('plagiarism.process');
    Route::get('/plagiarism-check/payment', [\App\Http\Controllers\PlagiarismController::class, 'showPayment'])->name('plagiarism.payment');
});

