<?php

namespace App\Entities;

use App\Enums\GateWays;
use App\Enums\TransactionStatuses;
use App\Repositories\Invoice\InvoiceRepository;
use App\Traits\HasTimeStamp;
use DateTimeInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


#[ORM\Entity(repositoryClass: InvoiceRepository::class)]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt')]
class Invoice
{
    use HasTimeStamp;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\OneToOne(targetEntity: Transaction::class, inversedBy: "invoice")]
    #[ORM\JoinColumn(name: "transaction_id", referencedColumnName: "id", nullable: false, onDelete: "CASCADE")]
    private Transaction $transaction;


    #[ORM\OneToMany(targetEntity: Invoice::class, mappedBy: "invoice_id")]
    public Collection $installments;


    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $trace_code = null;


    #[ORM\Column(type: Types::BOOLEAN, nullable: false)]
    private bool $termConditionsAccepted = false;


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


// Amount Getter and Setter
    public function getAmount(): int
    {
        return $this->getTransaction()->getAmount();
    }


// Status Getter and Setter
    public function getStatus(): TransactionStatuses
    {
        return $this->getTransaction()->getStatus();
    }


// TerminalId Getter and Setter
    public function getTerminalId(): int
    {
        return $this->getTransaction()->getTerminalId();
    }


// TraceNumber Getter and Setter
    public function getTraceNumber(): int
    {
        return $this->getTransaction()->getTraceNumber();
    }


// RRN Getter and Setter
    public function getRrn(): int
    {
        return $this->getTransaction()->getRrn();
    }


// SecurePan Getter and Setter
    public function getSecurePan(): int
    {
        return $this->getTransaction()->getSecurePan();
    }


// Token Getter and Setter
    public function getToken(): int
    {
        return $this->getTransaction()->getToken();
    }


// Gateway Getter and Setter
    public function getGateway(): GateWays
    {
        return $this->getTransaction()->getGateway();
    }

    public function getProjectName(): string
    {
        return $this->getTransaction()->getOrder()->getProject()->getTitle();
    }

}
