<?php

namespace App\Entities;


use App\Repositories\Project\ProjectRepository;
use App\Traits\HasTimeStamp;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;




#[ORM\Entity(repositoryClass: ProjectRepository::class)]
#[ORM\Table(name: 'projects')]
class Project
{
    use HasTimeStamp;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\OneToMany(targetEntity: Order::class, mappedBy: 'project')]
    private Collection $orders;


    #[ORM\Column(type: 'string', length: 255)]
    private string $title;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

}
