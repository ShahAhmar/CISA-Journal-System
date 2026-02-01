<?php

namespace Database\Seeders;

use App\Models\Journal;
use App\Models\JournalPageSetting;
use Illuminate\Database\Seeder;

class JournalPageSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $journals = Journal::all();

        foreach ($journals as $journal) {
            // Check if page settings already exist
            if ($journal->pageSettings()->count() > 0) {
                continue;
            }

            // Create default page settings
            $defaults = JournalPageSetting::getDefaults();

            foreach ($defaults as $setting) {
                $journal->pageSettings()->create($setting);
            }

            $this->command->info("Created default page settings for journal: {$journal->name}");
        }
    }
}
