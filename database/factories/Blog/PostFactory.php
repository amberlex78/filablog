<?php

namespace Database\Factories\Blog;

use App\Models\Blog\Post;
use Database\Factories\Traits\CreateFakeImage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    use CreateFakeImage;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $title = $this->faker->unique()->sentence(4),
            'slug' => Str::slug($title),
            'image' => $this->createImage(Post::IMG_BLOG_POST),
            'content' => $this->faker->realText(),
            'enabled' => $this->faker->boolean(),
            'published_at' => $this->faker->dateTimeBetween('-6 month', '+1 month'),
            'created_at' => $this->faker->dateTimeBetween('-1 year', '-6 month'),
            'updated_at' => $this->faker->dateTimeBetween('-5 month'),
        ];
    }
}
