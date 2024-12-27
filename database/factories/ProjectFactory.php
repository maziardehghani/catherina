<?php

namespace Database\Factories;

use App\Enums\Statuses;
use App\Models\City;
use App\Models\Project;
use App\Models\State;
use App\Models\Status;
use App\Models\User;
use App\Models\Warranty;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'title' => $this->faker->unique()->company(),
            'slug' => $this->faker->slug,
            'percent' => $this->faker->numberBetween(0, 100),
            'funding_period' => $this->faker->numberBetween(9, 12),
            'city_id' => City::query()->first()->id,
            'project_intro' => $this->faker->paragraph,
            'expert_opinion' => $this->faker->paragraph,
            'company_intro' => $this->faker->paragraph,
            'project_risks' => $this->faker->paragraph,
            'warranty_inquiry_id' => Warranty::query()->first()->id,
            'warranty_details' => $this->faker->paragraph,
            'participation_generated' => $this->faker->boolean,
            'status_id' => Status::query()->whereTitle(fake()->randomElement(Statuses::ProjectStatuses()))->first()->id,
            'stopped_at' => null,
        ];
    }
}
