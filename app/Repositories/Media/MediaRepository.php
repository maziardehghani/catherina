<?php

namespace App\Repositories\Media;


use App\Entities\User;
use Doctrine\ORM\EntityRepository;

class MediaRepository extends EntityRepository
{
    public function getMedias($id, $model, $type)
    {
        return $this->createQueryBuilder('m')
            ->where('m.mediableId = :id')
            ->andWhere('m.mediableType = :model')
            ->andWhere('m.type = :type')
            ->setParameter('id', $id)
            ->setParameter('model', $model)
            ->setParameter('type', $type)
            ->getQuery()
            ->getResult();
    }



    public function getMedia($id, $model, $type)
    {
        return $this->createQueryBuilder('m')
            ->where('m.mediableId = :id')
            ->andWhere('m.mediableType = :model')
            ->andWhere('m.type = :type')
            ->setParameter('id', $id)
            ->setParameter('model', $model)
            ->setParameter('type', $type)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getMediasOfUser(User $user)
    {
        return $this->createQueryBuilder('m')
            ->where('m.mediableId = :id')
            ->andWhere('m.mediableType = :type')
            ->setParameter('type' , $user::class)
            ->setParameter('id' , $user->getId())
            ->getQuery()
            ->getResult();

    }
}

