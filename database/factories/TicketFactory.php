<?php

namespace Database\Factories;

use App\Enums\Statuses;
use App\Enums\TicketCategories;
use App\Models\Status;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Ticket>
 */
class TicketFactory extends Factory
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
            'category' => $this->faker->randomElement(TicketCategories::categories()),
            'subject' => $this->faker->sentence(),
            'content' => $this->faker->paragraph(),
            'parent_id' => null,
            'status_id' => Status::query()->whereTitle(fake()->randomElement(Statuses::TicketStatuses()))->first()->getKey(),
        ];
    }
}
