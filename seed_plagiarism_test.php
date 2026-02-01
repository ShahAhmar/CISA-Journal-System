<?php

use App\Models\User;
use App\Models\Journal;
use App\Models\Submission;
use App\Models\SubmissionContent;
use App\Models\SubmissionFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// 1. Get or Create Journal
$journal = Journal::first() ?: Journal::create([
    'name' => 'Test Journal',
    'slug' => 'test-journal',
    'description' => 'A journal for testing',
]);

// 2. Get Admin
$admin = User::firstOrCreate(
    ['email' => 'admin@journal.com'],
    [
        'first_name' => 'Admin',
        'last_name' => 'User',
        'password' => Hash::make('password'),
        'role' => 'admin'
    ]
);

// 3. Create Submission 1 (Source)
$sub1 = Submission::create([
    'journal_id' => $journal->id,
    'user_id' => $admin->id,
    'title' => 'The Future of AI in Research',
    'abstract' => 'This is a source article about AI.',
    'status' => 'published',
    'submitted_at' => now(),
]);

$content1 = "Artificial intelligence is revolutionizing the way scientific research is conducted. Machine learning models can analyze vast datasets much faster than humans, identifying patterns that would otherwise remain hidden. This shift is particularly evident in genomics and climate science, where data volume is immense.";

SubmissionContent::create([
    'submission_id' => $sub1->id,
    'content' => $content1
]);

// 4. Create Submission 2 (Plagiarized)
$sub2 = Submission::create([
    'journal_id' => $journal->id,
    'user_id' => $admin->id,
    'title' => 'AI Impacts on Modern Science',
    'abstract' => 'This article copies some content from the first one.',
    'status' => 'submitted',
    'submitted_at' => now(),
]);

$content2 = "In modern science, artificial intelligence is revolutionizing the way scientific research is conducted. Many researchers now believe that machine learning models can analyze vast datasets much faster than humans, identifying patterns that would otherwise remain hidden. This is a very important development in genomics.";

SubmissionContent::create([
    'submission_id' => $sub2->id,
    'content' => $content2
]);

echo "Test data seeded successfully!\n";
echo "Submission 1 ID: " . $sub1->id . "\n";
echo "Submission 2 ID: " . $sub2->id . "\n";
echo "Journal Slug: " . $journal->slug . "\n";
