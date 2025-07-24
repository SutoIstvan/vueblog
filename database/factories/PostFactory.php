<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    protected $model = \App\Models\Post::class;

    // public function definition()
    // {
    //     $title = $this->faker->sentence();

    //     return [
    //         'title' => $title,
    //         'slug' => Str::slug($title) . '-' . $this->faker->unique()->numberBetween(1, 1000),
    //         'content' => $this->faker->paragraphs(3, true),
    //         'is_published' => true,
    //         'published_at' => $this->faker->dateTimeBetween('-1 years', 'now'),
    //         'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
    //         'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
    //         'image' => 'https://deifkwefumgah.cloudfront.net/shadcnblocks/block/placeholder-dark-1.svg',
    //         'meta_title' => $this->faker->sentence(6),
    //         'meta_description' => $this->faker->sentence(10),
    //     ];
    // }

public function definition()
{
    $title = $this->faker->randomElement([
        'Top 10 Gadgets Every Tech Lover Should Have',
        'The Rise of Foldable Smartphones in 2025',
        'How AI is Changing the Way We Live',
        '5 Best Smartwatches of the Year',
        'Why You Need a VPN in Today’s Digital World',
        'Electric Vehicles: What to Expect Next',
        'Wireless Charging Explained Simply',
        'The Future of Augmented Reality Glasses',
        'How to Build Your First Gaming PC',
        'Best Noise-Cancelling Headphones Reviewed',
        'Top Home Automation Devices for Beginners',
        'Will Robots Replace Human Jobs?',
        'The Pros and Cons of Smart TVs',
        'Exploring the New USB-C Standard',
        'How to Extend Your Laptop’s Battery Life',
        'Must-Have Tech Accessories for Remote Work',
        'Are Smart Fridges Worth the Hype?',
        'Understanding Cloud Storage and Backups',
        'The Truth About Bluetooth Radiation',
        'What’s Inside a Modern Smartphone?',
        'Best Budget Drones with HD Cameras',
        'Top 5 Fitness Trackers Compared',
        'The Evolution of Wearable Tech',
        'Beginner’s Guide to 3D Printing',
        'Latest Innovations in Electric Bicycles',
        'How Safe Are Your Smart Devices?',
        'Future Trends in Mobile App Development',
        'Gaming Laptops vs Desktops: Which to Choose?',
        'Everything You Need to Know About Wi-Fi 7',
        'How Tech is Revolutionizing Healthcare',
    ]);

    return [
        'title' => $title,
        'slug' => Str::slug($title) . '-' . $this->faker->unique()->numberBetween(1, 1000),
        'content' => $this->faker->paragraphs(3, true),
        'is_published' => true,
        'published_at' => $this->faker->dateTimeBetween('-1 years', 'now'),
        'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
        'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
        'image' => 'https://picsum.photos/600/400?random=' . $this->faker->unique()->numberBetween(1, 1000),
        'meta_title' => $this->faker->sentence(6),
        'meta_description' => $this->faker->sentence(10),
    ];
}

}
