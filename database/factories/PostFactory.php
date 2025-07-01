<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Post;

class PostFactory extends Factory
{
    public function definition(): array
    {
        $title = $this->faker->sentence(6, true);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->text(150),
            'content' => $this->faker->paragraphs(3, true),
            'publish_date' => $this->faker->optional()->dateTimeBetween('-1 month', '+1 week'),
            'status' => 0,
            'user_id' => 23,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Post $post) {
            $localImagePath = storage_path('app/public/1/per3.jpg');
            if (file_exists($localImagePath)) {
                $post->addMedia($localImagePath)
                    ->preservingOriginal()
                    ->toMediaCollection('thumbnail');
            }
        });
    }
}
