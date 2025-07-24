<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected $model = \App\Models\Category::class;

    public function definition()
    {
        $name = $this->faker->unique()->randomElement([
            'Cloud Computing',
            'AI Machine Learning',
            'Cybersecurity',
            'Software Development',
            'Mobile Development',
            'Data Science',
            'Web Technologies',
            'Blockchain',
            'Networking',
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->sentence(),
            'image' => null,
            'meta_title' => $this->faker->sentence(6),
            'meta_description' => $this->faker->sentence(10),
            'is_active' => true,
            'position' => $this->faker->numberBetween(0, 100),
        ];
    }
}
