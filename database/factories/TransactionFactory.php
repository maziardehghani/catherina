<?php

namespace Database\Factories;

use App\Enums\Statuses;
use App\Models\Order;
use App\Models\Status;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'amount' => $this->faker->randomFloat(2, 1, 100),
            'status_id' => Status::query()->whereTitle(fake()->randomElement(Statuses::TransactionStatuses()))->whereType(Transaction::class)->first()->getKey(),
            'terminal_id' => $this->faker->numberBetween(10000, 99999),
            'trace_number' => $this->faker->numberBetween(10000, 99999),
            'rrn' => $this->faker->numberBetween(10000, 99999),
            'secure_pan' => $this->faker->numberBetween(1000000000, 9999999999),
            'token' => fake()->uuid(),
            'gateWay' => $this->faker->randomElement(['online', 'receipt']),
        ];
    }
}
