<?php

use App\Entities\City;
use App\Entities\Installment;
use App\Entities\Invoice;
use App\Entities\Media;
use App\Entities\Project;
use App\Entities\Transaction;
use App\Entities\User;
use App\Repositories\City\CityRepository;
use App\Repositories\Installment\InstallmentRepository;
use App\Repositories\Invoice\InvoiceRepository;
use App\Repositories\Media\MediaRepository;
use App\Repositories\Project\ProjectRepository;
use App\Repositories\Transaction\TransactionRepository;
use App\Repositories\User\UserRepository;

return [
    'binders' => [
        UserRepository::class => User::class,
        MediaRepository::class => Media::class,
        InvoiceRepository::class => Invoice::class,
        TransactionRepository::class => Transaction::class,
        InstallmentRepository::class => Installment::class,
        ProjectRepository::class => Project::class,
        CityRepository::class => City::class
    ]
];
