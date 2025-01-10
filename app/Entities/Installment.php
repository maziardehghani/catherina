<?php

namespace App\Entities;


use App\Enums\TransactionStatuses;
use App\Repositories\Installment\InstallmentRepository;
use App\Traits\HasTimeStamp;
use DateTimeInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;




#[ORM\Entity(repositoryClass: InstallmentRepository::class)]
#[ORM\Table(name: 'installments')]
class Installment
{
    use HasTimeStamp;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\ManyToOne(targetEntity: Invoice::class, inversedBy: 'installments')]
    #[ORM\JoinColumn(referencedColumnName: 'id', nullable: false, fieldName: 'invoice_id')]
    private Invoice $invoice;



    #[ORM\Column(type: 'integer')]
    private ?int $amount;


    #[ORM\Column(type: Types::ENUM, nullable: false)]
    private TransactionStatuses $status;


    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $description = null;




    #[ORM\Column(type: 'datetime', nullable: false)]
    private DateTimeInterface $dueDate;



    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?DateTimeInterface $paymentDate = null;



    // Getter and Setter for id
    public function getId(): ?int
    {
        return $this->id;
    }

    // Getter and Setter for invoice
    public function getInvoice(): Invoice
    {
        return $this->invoice;
    }

    public function setInvoice(Invoice $invoice): self
    {
        $this->invoice = $invoice;
        return $this;
    }

    // Getter and Setter for amount
    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(?int $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    // Getter and Setter for status
    public function getStatus(): TransactionStatuses
    {
        return $this->status;
    }

    public function setStatus(TransactionStatuses $status): self
    {
        $this->status = $status;
        return $this;
    }

    // Getter and Setter for description
    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    // Getter and Setter for dueDate
    public function getDueDate(): DateTimeInterface
    {
        return $this->dueDate;
    }

    public function setDueDate(DateTimeInterface $dueDate): self
    {
        $this->dueDate = $dueDate;
        return $this;
    }

    // Getter and Setter for paymentDate
    public function getPaymentDate(): ?DateTimeInterface
    {
        return $this->paymentDate;
    }

    public function setPaymentDate(?DateTimeInterface $paymentDate): self
    {
        $this->paymentDate = $paymentDate;
        return $this;
    }
}
