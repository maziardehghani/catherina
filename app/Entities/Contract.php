<?php

namespace App\Entities;


use App\Enums\ContractTypes;
use App\Enums\DocumentTypes;
use App\Traits\HasTimeStamp;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;



#[ORM\Entity]
#[ORM\Table(name: 'contracts')]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt')]
class Contract
{
    use HasTimeStamp;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'contracts')]
    #[ORM\JoinColumn(referencedColumnName: 'id', nullable: false, fieldName: 'user_id')]
    private User $user;


    #[ORM\ManyToOne(targetEntity: Project::class, inversedBy: 'contracts')]
    #[ORM\JoinColumn(referencedColumnName: 'id', nullable: false, fieldName: 'project_id')]
    private Project $project;


    #[ORM\Column(type: 'string', length: 255)]
    private string $title;


    #[ORM\Column(type: Types::TEXT, length: 255)]
    private string $description;


    #[ORM\Column(type: Types::ENUM)]
    private ContractTypes $type;


    #[ORM\Column(type: Types::ENUM)]
    private DocumentTypes $documentType;



    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?DateTimeInterface $deletedAt= null   ;


}
