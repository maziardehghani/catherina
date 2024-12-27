<?php

namespace App\Http\Controllers;

use App\Enums\Statuses;
use App\Http\Resources\Status\StatusResources;
use App\Models\Installment;
use App\Models\Status;
use App\Models\Ticket;
use App\Models\Transaction;

class StatusController extends Controller
{
    public function userStatuses()
    {
        $statuses = Status::query()->whereTitleIn(Statuses::commonStatuses())->get();

        return response()->success(StatusResources::collection($statuses));
    }

    public function ticketStatuses()
    {
        $statuses = Status::query()
            ->whereTitleIn(Statuses::TicketStatuses())
            ->whereType(Ticket::class)
            ->get();;

        return response()->success(StatusResources::collection($statuses));
    }

    public function projectStatuses()
    {
        $statuses = Status::query()->whereTitleIn(Statuses::ProjectStatuses())->get();

        return response()->success(StatusResources::collection($statuses));
    }

    public function transactionStatuses()
    {
        $statuses = Status::query()
            ->whereTitleIn(Statuses::TransactionStatuses())
            ->whereType(Transaction::class)
            ->get();

        return response()->success(StatusResources::collection($statuses));
    }

    public function installmentStatuses()
    {
        $statuses = Status::query()
            ->whereTitleIn(Statuses::installmentStatuses())
            ->whereType(Installment::class)
            ->get();;

        return response()->success(StatusResources::collection($statuses));
    }
}
