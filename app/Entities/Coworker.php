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
#[ORM\Table(name: 'coworkers')]
class Coworker
{
    use HasTimeStamp;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string  $title = null;


    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string  $link = null;




}
