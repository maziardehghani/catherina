<?php

namespace Database\Factories;

use App\Enums\Statuses;
use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Slider>
 */
class SliderFactory extends Factory
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
            'link' => $this->faker->url(),
            'status_id' => Status::query()->whereTitle(fake()->randomElement(Statuses::commonStatuses()))->first()->getKey(),
            'order' => $this->faker->numberBetween(1,10),
        ];
    }
}
