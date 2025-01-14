<?php

namespace App\Traits;

use App\Entities\Media;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;


trait HasMedia
{
    public function getMedias($type): object|array|null
    {
        return resolve(EntityManagerInterface::class)
            ->getRepository(Media::class)
            ->getMedias($this->getId(), static::class, $type);
    }

    public function getMedia($type): object|array|null
    {
        return resolve(EntityManagerInterface::class)
            ->getRepository(Media::class)
            ->getMedia($this->getId(), static::class, $type);
    }
}
