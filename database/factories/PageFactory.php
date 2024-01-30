<?php

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Page>
 */
class PageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->name;

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => fake()->text(500),
            'is_published' => rand(0, 1) % 2,
        ];
    }
}
