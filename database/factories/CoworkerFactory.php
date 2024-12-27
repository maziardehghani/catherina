<?php

namespace Database\Factories;

use App\Enums\Statuses;
use App\Models\Coworker;
use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Coworker>
 */
class CoworkerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->company(),
            'link' => $this->faker->url(),
            'status_id' => Status::query()->whereTitle(fake()->randomElement(Statuses::commonStatuses()))->first()->getKey()
        ];
    }
}
