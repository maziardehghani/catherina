<?php

namespace App\Entities;


use App\Enums\ContractTypes;
use App\Enums\DocumentTypes;
use App\Traits\HasStatus;
use App\Traits\HasTimeStamp;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;



#[ORM\Entity]
#[ORM\Table(name: 'coworkers')]
class Coworker
{
    use HasTimeStamp,HasStatus;


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string  $title = null;


    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string  $link = null;


// Getter and Setter for id
    public function getId(): ?int
    {
        return $this->id;
    }

// Getter and Setter for title
    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;
        return $this;
    }

// Getter and Setter for link
    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;
        return $this;
    }


}
