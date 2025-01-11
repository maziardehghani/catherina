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
    private ?DateTimeInterface $deletedAt= null;

    // Getter and Setter for id
    public function getId(): ?int
    {
        return $this->id;
    }

// Getter and Setter for user
    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

// Getter and Setter for project
    public function getProject(): Project
    {
        return $this->project;
    }

    public function setProject(Project $project): self
    {
        $this->project = $project;
        return $this;
    }

// Getter and Setter for title
    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

// Getter and Setter for description
    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

// Getter and Setter for type
    public function getType(): ContractTypes
    {
        return $this->type;
    }

    public function setType(ContractTypes $type): self
    {
        $this->type = $type;
        return $this;
    }

// Getter and Setter for documentType
    public function getDocumentType(): DocumentTypes
    {
        return $this->documentType;
    }

    public function setDocumentType(DocumentTypes $documentType): self
    {
        $this->documentType = $documentType;
        return $this;
    }

// Getter and Setter for deletedAt
    public function getDeletedAt(): ?DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;
        return $this;
    }



}
