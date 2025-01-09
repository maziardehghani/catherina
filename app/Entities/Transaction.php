<?php

namespace App\Entities;


use App\Enums\GateWays;
use App\Enums\TransactionStatuses;
use App\Repositories\Transaction\TransactionRepository;
use App\Traits\HasTimeStamp;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;



#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: TransactionRepository::class)]
class Transaction
{
    use HasTimeStamp;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\OneToOne(targetEntity: Invoice::class, mappedBy: 'transaction')]
    private Invoice $invoice;


    #[ORM\Column(type: 'integer', length: 10, nullable: false)]
    private int $amount;


    #[ORM\Column(type: Types::ENUM, nullable: false)]
    private TransactionStatuses $status;


    #[ORM\Column(type: 'integer', length: 10, nullable: false)]
    private int $terminalId;

    #[ORM\Column(type: 'integer', length: 6, nullable: false)]
    private int $traceNumber;


    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private int $rrn;


    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private int $securePan;


    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private int $token;


    #[ORM\Column(type: Types::ENUM, nullable: false)]
    private GateWays $gateway;

    #[ORM\Column(type: 'datetime', nullable: true)]
    #[Gedmo\Timestampable(on: 'create')]
    private ?DateTimeInterface $createdAt = null;


    #[ORM\Column(type: 'datetime', nullable: true)]
    #[Gedmo\Timestampable(on: 'update')]
    private ?DateTimeInterface $updatedAt = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?DateTimeInterface $deletedAt = null;

    public function getInvoice(): Invoice
    {
        return $this->invoice;
    }

    public function setInvoice(Invoice $invoice): self
    {
        $this->invoice = $invoice;
        return $this;
    }

// Amount Getter and Setter
    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

// Status Getter and Setter
    public function getStatus(): TransactionStatuses
    {
        return $this->status;
    }

    public function setStatus(TransactionStatuses $status): self
    {
        $this->status = $status;
        return $this;
    }

// TerminalId Getter and Setter
    public function getTerminalId(): int
    {
        return $this->terminalId;
    }

    public function setTerminalId(int $terminalId): self
    {
        $this->terminalId = $terminalId;
        return $this;
    }

// TraceNumber Getter and Setter
    public function getTraceNumber(): int
    {
        return $this->traceNumber;
    }

    public function setTraceNumber(int $traceNumber): self
    {
        $this->traceNumber = $traceNumber;
        return $this;
    }

// RRN Getter and Setter
    public function getRrn(): int
    {
        return $this->rrn;
    }

    public function setRrn(int $rrn): self
    {
        $this->rrn = $rrn;
        return $this;
    }

// SecurePan Getter and Setter
    public function getSecurePan(): int
    {
        return $this->securePan;
    }

    public function setSecurePan(int $securePan): self
    {
        $this->securePan = $securePan;
        return $this;
    }

// Token Getter and Setter
    public function getToken(): int
    {
        return $this->token;
    }

    public function setToken(int $token): self
    {
        $this->token = $token;
        return $this;
    }

// Gateway Getter and Setter
    public function getGateway(): GateWays
    {
        return $this->gateway;
    }

    public function setGateway(GateWays $gateway): self
    {
        $this->gateway = $gateway;
        return $this;
    }

// CreatedAt Getter and Setter
    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

// UpdatedAt Getter and Setter
    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

// DeletedAt Getter and Setter
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
