<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Demo User',
            'email' => 'demo@example.com',
        ]);

        \App\Models\Note::factory()->count(5)->create([
            'user_id' => $user->id,
        ]);

        \App\Models\Note::factory()->count(2)->pinned()->create([
            'user_id' => $user->id,
        ]);

        \App\Models\Note::factory()->count(3)->archived()->create([
            'user_id' => $user->id,
        ]);
    }
}
