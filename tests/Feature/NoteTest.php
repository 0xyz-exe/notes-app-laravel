<?php

namespace Tests\Feature;

use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NoteTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_notes_index(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/notes');

        $response->assertStatus(200);
    }

    public function test_user_can_create_note(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/notes', [
            'title' => 'Test Note',
            'content' => 'Test content',
            'category' => 'Work',
            'tags' => 'test,php',
        ]);

        $response->assertRedirect('/notes');
        $this->assertDatabaseHas('notes', [
            'title' => 'Test Note',
            'user_id' => $user->id,
        ]);
    }

    public function test_user_can_pin_note(): void
    {
        $user = User::factory()->create();
        $note = Note::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->post("/notes/{$note->id}/pin");

        $note->refresh();
        $this->assertTrue($note->is_pinned);
    }

    public function test_user_can_archive_note(): void
    {
        $user = User::factory()->create();
        $note = Note::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->post("/notes/{$note->id}/archive");

        $note->refresh();
        $this->assertTrue($note->is_archived);
    }

    public function test_user_cannot_view_other_users_note(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $note = Note::factory()->create(['user_id' => $user1->id]);

        $response = $this->actingAs($user2)->get("/notes/{$note->id}");

        $response->assertForbidden();
    }

    public function test_soft_delete_works(): void
    {
        $user = User::factory()->create();
        $note = Note::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)->delete("/notes/{$note->id}");

        $this->assertSoftDeleted('notes', ['id' => $note->id]);
    }
}
