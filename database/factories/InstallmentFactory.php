<?php

namespace Database\Factories;

use App\Enums\Statuses;
use App\Models\Installment;
use App\Models\Invoice;
use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Installment>
 */
class InstallmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'invoice_id' => Invoice::factory(),
            'amount' => $this->faker->numberBetween(1000, 1000000000),
            'status_id' => Status::query()->whereType(Installment::class)->whereTitle(fake()->randomElement(Statuses::installmentStatuses()))->first()->getKey(),
            'description' => $this->faker->sentence(),
            'due_date' => $this->faker->date(),
        ];
    }
}
