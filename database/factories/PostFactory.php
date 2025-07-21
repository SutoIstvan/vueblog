<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    protected $model = \App\Models\Post::class;

    public function definition()
    {
        $title = $this->faker->sentence();

        return [
            'title' => $title,
            'slug' => Str::slug($title) . '-' . $this->faker->unique()->numberBetween(1, 1000),
            'content' => $this->faker->paragraphs(3, true),
            'is_published' => true,
            'published_at' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'image' => 'https://deifkwefumgah.cloudfront.net/shadcnblocks/block/placeholder-dark-1.svg',
            'meta_title' => $this->faker->sentence(6),
            'meta_description' => $this->faker->sentence(10),
        ];
    }
}
