<?php

namespace App\Entities;


use App\Enums\UserTypes;
use App\Repositories\Invoice\InvoiceRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


#[ORM\Entity(repositoryClass: InvoiceRepository::class)]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt')]
class Invoice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\OneToOne(targetEntity: Transaction::class, inversedBy: "invoice")]
    #[ORM\JoinColumn(name: "transaction_id", referencedColumnName: "id", nullable: false, onDelete: "CASCADE")]
    private Transaction $transaction;


    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $trace_code = null;


    #[ORM\Column(type: Types::BOOLEAN, nullable: false)]
    private bool $termConditionAccepted = false;


    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?DateTimeInterface $deletedAt = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTransaction(): Transaction
    {
        return  $this->transaction;
    }

    public function setTransaction(Transaction $transaction): self
    {
        $this->transaction = $transaction;
        return $this;
    }


    public function getTraceCode(): ?string
    {
        return $this->trace_code;
    }

    public function setTraceCode(?string $trace_code): self
    {
        $this->trace_code = $trace_code;
        return $this;
    }


    public function getTermConditionAccepted(): bool
    {
        return $this->termConditionAccepted;
    }


    public function setTermConditionAccepted(bool $termConditionAccepted): self
    {
        $this->termConditionAccepted = $termConditionAccepted;
        return $this;
    }



}
