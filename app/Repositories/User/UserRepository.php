<?php

namespace App\Repositories\User;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;


class UserRepository extends EntityRepository
{
    public function findByEmail(string $email)
    {
        return $this->findOneBy(['email' => $email]);
    }

    public function paginate($page = 1, $limit = 10)
    {
        $queryBuilder = $this->createQueryBuilder('u')
            ->orderBy('u.createdAt', 'DESC')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);

        $paginator = new Paginator($queryBuilder->getQuery(), true);


        return [
            'data' => iterator_to_array($paginator),
            'current_page' => $page,
            'per_page' => $limit,
            'total' => $paginator->count(),
        ];
    }

    public function findAllOrderedByName()
    {
        return $this->createQueryBuilder('u')
            ->orderBy('u.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
