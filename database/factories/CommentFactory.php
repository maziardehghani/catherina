<?php

namespace Database\Factories;

use App\Enums\Statuses;
use App\Models\Article;
use App\Models\Project;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Model>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::query()->first()->id,
            'commentable_id' => fake()->randomElement([Article::query()->first()->id, Project::query()->first()->id]),
            'commentable_type' => fake()->randomElement([Article::class, Project::class]),
            'parent_id' => null,
            'content' => $this->faker->sentence(),
            'status_id' => Status::query()->whereTitle(fake()->randomElement(Statuses::commonStatuses()))->first()->getKey()
        ];
    }
}
