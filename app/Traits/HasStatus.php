<?php

namespace App\Traits;


use App\Entities\Status;
use Doctrine\ORM\Mapping as ORM;


trait HasStatus
{
    #[ORM\OneToOne(targetEntity: Status::class, inversedBy: 'status')]
    #[ORM\JoinColumn(referencedColumnName: 'id', nullable: false, fieldName: 'status_id')]
    private Status $status;

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function setStatus(Status $status): self
    {
        $this->status = $status;
        return $this;
    }


}
