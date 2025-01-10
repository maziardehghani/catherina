<?php

use App\Entities\Invoice;
use App\Entities\Media;
use App\Entities\Transaction;
use App\Entities\User;
use App\Repositories\Invoice\InvoiceRepository;
use App\Repositories\Media\MediaRepository;
use App\Repositories\Transaction\TransactionRepository;
use App\Repositories\User\UserRepository;

return [
    'binders' => [
        UserRepository::class => User::class,
        MediaRepository::class => Media::class,
        InvoiceRepository::class => Invoice::class,
        TransactionRepository::class => Transaction::class,
    ]
];
