<?php

namespace App\Entities;


use App\Repositories\Project\ProjectRepository;
use App\Traits\HasTimeStamp;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity]
#[ORM\Table(name: 'articles')]
class Article
{
    use HasTimeStamp;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'articles')]
    #[ORM\JoinColumn(referencedColumnName: 'id', nullable: false, fieldName: 'user_id')]
    private User $user;


    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $title;


    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $slug;


    #[ORM\Column(type: Types::TEXT, length: 255, nullable: false)]
    private string $intro;


    #[ORM\Column(type: Types::TEXT, length: 255, nullable: false)]
    private string $content;

    #[ORM\ManyToOne(targetEntity: Status::class)]
    #[ORM\JoinColumn(referencedColumnName: 'id', nullable: false, fieldName: 'status_id')]
    private Status $status;
}
