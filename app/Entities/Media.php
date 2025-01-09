<?php

namespace App\Entities;



use App\Repositories\Media\MediaRepository;
use App\Traits\HasTimeStamp;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\Timestampable;

#[Table(name: 'medias')]
#[Entity(repositoryClass: MediaRepository::class)]
class Media
{
    use HasTimeStamp;


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;


    #[ORM\Column(type: 'string', length: 255)]
    private string $name;


    #[ORM\Column(type: 'string', length: 255)]
    public string $url;


    #[ORM\Column(type: 'string', length: 255)]
    private string $type;


    #[ORM\Column(type: 'string', length: 255)]
    private string $mediableType;

    #[ORM\Column(type: 'integer', length: 255)]
    private int $mediableId;


    public function getId(): int
    {
        return $this->id;
    }

    // Getter and setter for $name
    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    // Getter and setter for $url
    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    // Getter and setter for $type
    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    // Getter and setter for $mediableType
    public function getMediableType(): string
    {
        return $this->mediableType;
    }

    public function setMediableType(string $mediableType): self
    {
        $this->mediableType = $mediableType;
        return $this;
    }

    // Getter and setter for $mediableId
    public function getMediableId(): int
    {
        return $this->mediableId;
    }

    public function setMediableId(int $mediableId): self
    {
        $this->mediableId = $mediableId;
        return $this;
    }




}
