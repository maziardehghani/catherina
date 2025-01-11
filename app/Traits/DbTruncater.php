<?php

namespace App\Traits;

use Doctrine\ORM\EntityManagerInterface;

trait DbTruncater
{
    public function truncate(EntityManagerInterface $entityManager,$table): void
    {
        $entityManager->getConnection()
            ->executeQuery('SET FOREIGN_KEY_CHECKS = 0');

        $entityManager->getConnection()
            ->executeQuery("TRUNCATE TABLE $table");

        $entityManager->getConnection()
            ->executeQuery('SET FOREIGN_KEY_CHECKS = 1');
    }
}
