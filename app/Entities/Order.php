<?php

namespace App\Entities;


use App\Enums\GateWays;
use App\Enums\TransactionStatuses;
use App\Repositories\Order\OrderRepository;
use App\Repositories\Transaction\TransactionRepository;
use App\Traits\HasTimeStamp;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\Timestampable;


#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: 'orders')]
class Order
{
    use HasTimeStamp;


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'orders')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false)]
    private User $user;



    #[ORM\ManyToOne(targetEntity: Project::class, inversedBy: 'orders')]
    #[ORM\JoinColumn(name: 'project_id', referencedColumnName: 'id', nullable: false)]
    private Project $project;


    #[ORM\OneToOne(targetEntity: Transaction::class, mappedBy: 'order')]
    private Transaction $transaction;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProject(): Project
    {
        return $this->project;
    }

    public function setProject(Project $project): self
    {
        $this->project = $project;
        return $this;
    }


    public function getTransaction(): Transaction
    {
        return $this->transaction;
    }


    public function setTransaction(Transaction $transaction): self
    {
        $this->transaction = $transaction;
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



}
