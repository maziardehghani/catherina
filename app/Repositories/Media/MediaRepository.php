<?php

namespace App\Repositories\Media;


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
}

