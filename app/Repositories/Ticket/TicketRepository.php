<?php

namespace App\Repositories\Ticket;

use App\Models\Ticket;
use App\Repositories\Repository;

class TicketRepository extends Repository
{
    public function __construct()
    {
        $this->model = Ticket::query();
        $this->paginate = 20;
    }
}
