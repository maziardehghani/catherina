<?php

namespace App\Entities;


use App\Enums\GateWays;
use App\Enums\TransactionStatuses;
use App\Repositories\Transaction\TransactionRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;



#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: TransactionRepository::class)]
class Transaction
{
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


    public function getInvoice(): Invoice
    {
        return $this->invoice;
    }

    public function setInvoice(Invoice $invoice): self
    {
        $this->invoice = $invoice;
        return $this;
    }
    #[ORM\Column(type: 'datetime', nullable: true)]
    #[Gedmo\Timestampable(on: 'create')]
    private ?DateTimeInterface $createdAt = null;


    #[ORM\Column(type: 'datetime', nullable: true)]
    #[Gedmo\Timestampable(on: 'update')]
    private ?DateTimeInterface $updatedAt = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?DateTimeInterface $deletedAt = null;




}
