<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected $model = \App\Models\Category::class;

    public function definition()
    {
        $name = $this->faker->unique()->words(2, true);

        return [
            'name' => ucfirst($name),
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
