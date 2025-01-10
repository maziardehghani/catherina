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
}
