<?php

namespace App\Entities;


use App\Repositories\Project\ProjectRepository;
use App\Traits\HasTimeStamp;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;



#[ORM\Entity]
#[ORM\Table(name: 'cities')]
class City
{
    use HasTimeStamp;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255,)]
    private string $name;


    #[ORM\ManyToOne(targetEntity: State::class, inversedBy: 'cities')]
    #[ORM\JoinColumn(referencedColumnName: 'id', nullable: false, fieldName: 'state_id')]
    private string $state;
}
