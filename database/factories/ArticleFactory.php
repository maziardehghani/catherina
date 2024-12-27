<?php

namespace Database\Factories;

use App\Enums\Statuses;
use App\Models\Article;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'user_id' => User::query()->first()->getKey(),
            'slug' => $this->faker->slug(),
            'content' => $this->faker->paragraph(),
            'intro' => $this->faker->paragraph(),
            'status_id' => Status::query()->whereTitle(fake()->randomElement(Statuses::commonStatuses()))->first()->getKey()
        ];
    }
}
