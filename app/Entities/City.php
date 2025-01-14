<?php

namespace App\Entities;


use App\Repositories\City\CityRepository;
use App\Traits\HasTimeStamp;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Table(name: 'cities')]
#[ORM\Entity(repositoryClass: CityRepository::class)]
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
    private State $state;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getState(): State
    {
        return $this->state;
    }

    public function setState(State $state): self
    {
        $this->state = $state;
        return $this;
    }


}
