<?php

use App\Repositories\Media\MediaRepository;
use App\Repositories\User\UserRepository;

return [
    'binders' => [
        UserRepository::class => \App\Entities\User::class,
        MediaRepository::class => \App\Entities\Media::class,
    ]
];
