<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Page::factory(3)
            ->sequence([
                'title' => 'About Us',
                'slug' => Str::slug('About Us'),
                'content' => fake()->text(500),
                'enabled' => 1,
            ], [
                'title' => 'Payment',
                'slug' => Str::slug('Payment'),
                'content' => fake()->text(500),
                'enabled' => 1,
            ], [
                'title' => 'Service',
                'slug' => Str::slug('Service'),
                'content' => fake()->text(500),
                'enabled' => 1,
            ])
            ->create();
    }
}
