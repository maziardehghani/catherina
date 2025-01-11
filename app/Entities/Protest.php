<?php

namespace App\Entities;


use App\Repositories\Project\ProjectRepository;
use App\Traits\HasTimeStamp;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;



#[ORM\Entity]
#[ORM\Table(name: 'protests')]
class Protest
{
    use HasTimeStamp;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Project::class)]
    #[ORM\JoinColumn(referencedColumnName: 'id', nullable: false, fieldName: 'project_id')]
    private Project $project;


    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(referencedColumnName: 'id', nullable: false, fieldName: 'user_id')]
    private User $user;

    #[ORM\Column(type: Types::TEXT)]
    private string $content;


    public function getProject(): Project
    {
        return $this->project;
    }

    public function setProject(Project $project): self
    {
        $this->project = $project;
        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }


    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent($content): self
    {
        $this->content = $content;
        return $this;
    }
}
