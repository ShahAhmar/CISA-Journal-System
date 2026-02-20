<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_has_full_name_attribute()
    {
        $user = User::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
        ]);

        $this->assertEquals('John Doe', $user->full_name);
    }

    public function test_user_can_have_journal_role()
    {
        $user = User::factory()->create();
        $journal = \App\Models\Journal::factory()->create();

        $user->journals()->attach($journal->id, [
            'role' => 'editor',
            'is_active' => true,
        ]);

        $this->assertTrue($user->hasJournalRole($journal->id, 'editor'));
    }
}

