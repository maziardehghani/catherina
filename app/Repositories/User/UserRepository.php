<?php

namespace App\Repositories\User;

use App\Entities\User;
use App\Entities\UsersInfosTitles;
use App\Entities\UsersInfosValues;
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


    public function storeSejamInfos(array $datas, User $user)
    {
        $entityManager = $this->getEntityManager();

        foreach ($datas as $key => $item) {

            $userInfoTitle = $entityManager->createQueryBuilder()
                ->select('uit')
                ->from(UsersInfosTitles::class, 'uit')
                ->where('uit.title = :title')
                ->setParameter('title', $key)
                ->getQuery()
                ->getOneOrNullResult();

            if (is_null($userInfoTitle) || is_null($item)) {
                continue;
            }

            $this->storeUserValue($user, $userInfoTitle, $item);
        }
    }

    private function storeUserValue($user, $userInfoTitle, $item)
    {
        $entityManager = $this->getEntityManager();

        $userInfoValue = $entityManager->createQueryBuilder()
            ->select('uiv')
            ->from(UsersInfosValues::class, 'uiv')
            ->where('uiv.user = :user')
            ->andwhere('uiv.usersInfosTitles = :userInfoTitle')
            ->setParameter('user', $user)
            ->setParameter('userInfoTitle', $userInfoTitle)
            ->getQuery()
            ->getOneOrNullResult();

        if ($userInfoValue) {
            $userInfoValue->setValue($item);
        } else {

            $userInfoValue = new UsersInfosValues();
            $userInfoValue->setUser($user);
            $userInfoValue->setUserTitleInfo($userInfoTitle);
            $userInfoValue->setValue($item);

            $entityManager->persist($userInfoValue);
        }

        $entityManager->flush();

        return $userInfoValue;
    }

    public function findAllOrderedByName()
    {
        return $this->createQueryBuilder('u')
            ->orderBy('u.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
}



//public function storeSejamInfos($data, $user): void
//{
//    foreach ($data as $key => $item) {
//
//        $userInfoTitle = UserInfoTitle::query()->where('title', $key)->first();
//
//        // refuse to insert sejam data if it is null
//        if (is_null($userInfoTitle) || is_null($item)) {
//            continue;
//        }
//
//        $this->storeUserValues($user, $userInfoTitle, $item);
//
//    }
//
//}
//
//public function deleteSejamInfos($user): void
//{
//    $user->userInfos()->delete();
//}
//
//
//private function storeUserValues($user, $userInfoTitle, $item): void
//{
//    UserInfoValue::query()->updateOrCreate([
//        'user_id' => $user->id,
//        'user_info_title_id' => $userInfoTitle->id,
//    ], [
//        'user_id' => $user->id,
//        'user_info_title_id' => $userInfoTitle->id,
//        'value' => $item,
//    ]);
//}


