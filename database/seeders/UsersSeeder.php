<?php

namespace Database\Seeders;

use App\Models\Installment;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(10)->create()->each(function ($user) {

            Order::factory()->count(10)->create(['user_id' => $user->id ])
                ->each(function ($order) use ($user) {


                    Transaction::factory()->count(1)->create(['order_id' => $order->id])
                        ->each(function ($transaction) use ($order) {

                            if ($transaction->status_id == 18) { // it means if transaction not paid

                                Invoice::factory()->count(1)->create(['transaction_id' => $transaction->id])
                                    ->each(function ($invoice) use ($order) {

                                        Installment::factory()->count(3)->create(['invoice_id' => $invoice->id]);

                                    });
                            }

                        });


                });

        });
    }
}
