<?php

namespace Database\Seeders;

use App\Enums\Statuses;
use App\Models\Installment;
use App\Models\Project;
use App\Models\Status;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect(Statuses::commonStatuses())->map(function ($status) {
            Status::query()->create([
                'model' => User::class,
                'title' => $status,
            ]);
        });

        collect(Statuses::TicketStatuses())->map(function ($status) {
            Status::query()->create([
                'model' => Ticket::class,
                'title' => $status,
            ]);
        });

        collect(Statuses::ProjectStatuses())->map(function ($status) {
            Status::query()->create([
                'model' => Project::class,
                'title' => $status,
            ]);
        });

        collect(Statuses::TransactionStatuses())->map(function ($status) {
            Status::query()->create([
                'model' => Transaction::class,
                'title' => $status,
            ]);
        });

        collect(Statuses::installmentStatuses())->map(function ($status) {
            Status::query()->create([
                'model' => Installment::class,
                'title' => $status,
            ]);
        });
    }
}
