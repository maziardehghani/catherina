<?php

namespace App\Traits;


use App\Entities\Status;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;


trait HasStatus
{
    #[ORM\ManyToOne(targetEntity: Status::class, inversedBy: 'status')]
    #[ORM\JoinColumn(referencedColumnName: 'id', nullable: false, fieldName: 'status_id')]
    private Status $status;

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function setStatus(int|Status $status): self
    {
        if (is_int($status)) {
            $status = resolve(EntityManagerInterface::class)->find(Status::class, $status);
        }
        $this->status = $status;
        return $this;
    }


}
