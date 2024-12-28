<?php

namespace App\Repositories\User;

use App\Entities\User;
use App\Enums\UserTypes;
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


    public function getLegalUsers()
    {
        return $this->createQueryBuilder('u')
            ->where('u.type = :type')
            ->setParameter('type', 'legal')
            ->getQuery()
            ->getResult();
    }

    public function store(object $data): object
    {
        $user = new User();
        $user->setName($data['name']);
        $user->setFamily($data['family']);
        $user->setIsPrivateInvestor($data['is_private_investor']);
        $user->setMobile($data['mobile']);
        $user->setEmail($data['email']);
        $user->setType(UserTypes::REAL);
        $user->setIsSejami($data['is_sejami']);
        $user->setStatusId($data['status_id']);
        $user->setBio($data['bio']);
        $user->setPassword($data['password']);


        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
        return $user;
    }

    public function findAllOrderedByName()
    {
        return $this->createQueryBuilder('u')
            ->orderBy('u.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
