<?php

namespace App\Entities;


use App\Repositories\Project\ProjectRepository;
use App\Traits\HasStatus;
use App\Traits\HasTimeStamp;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity]
#[ORM\Table(name: 'articles')]
class Article
{
    use HasTimeStamp,HasStatus;

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


    // Getters and Setters

    // ID
    public function getId(): ?int
    {
        return $this->id;
    }

    // User
    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    // Title
    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    // Slug
    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    // Intro
    public function getIntro(): string
    {
        return $this->intro;
    }

    public function setIntro(string $intro): self
    {
        $this->intro = $intro;
        return $this;
    }

    // Content
    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

}
