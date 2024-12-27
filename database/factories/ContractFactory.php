<?php

namespace Database\Factories;

use App\Enums\ContractTypes;
use App\Enums\Statuses;
use App\Models\Contract;
use App\Models\Project;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Contract>
 */
class ContractFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->title(),
            'user_id' => User::query()->first()->getKey(),
            'project_id' => Project::query()->first()->getKey(),
            'description' => fake()->sentence(),
            'type' => ContractTypes::INVESTOR_CONTRACT->value,
            'document_type' => 'contract',
            'status_id' => Status::query()->whereTitle(fake()->randomElement(Statuses::commonStatuses()))->first()->getKey()
        ];
    }
}
