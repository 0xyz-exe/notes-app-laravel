<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NoteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'content' => fake()->paragraphs(3, true),
            'category' => fake()->optional(0.7)->randomElement(['Work', 'Personal', 'Ideas', 'Todo']),
            'tags' => fake()->optional(0.5)->passthrough([
                fake()->word(),
                fake()->word(),
            ]),
            'is_pinned' => fake()->boolean(10),
            'is_archived' => false,
        ];
    }

    public function pinned(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_pinned' => true,
        ]);
    }

    public function archived(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_archived' => true,
        ]);
    }
}
