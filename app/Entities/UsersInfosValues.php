<?php

namespace App\Entities;


use App\Traits\HasTimeStamp;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\Timestampable;


#[ORM\Entity]
#[ORM\Table(name: 'users_infos_values')]
class UsersInfosValues
{
    use HasTimeStamp;


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'usersInfosValues')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;


    #[ORM\ManyToOne(targetEntity: UsersInfosTitles::class, inversedBy: 'usersInfosValues')]
    #[ORM\JoinColumn(name: 'user_info_title_id', referencedColumnName: 'id', nullable: false)]
    private UsersInfosTitles $usersInfosTitles ;


    #[ORM\Column(type: 'string', length: 255)]
    private ?string $value;



    public function getId(): ?int
    {
        return $this->id;
    }


    public function getUser(): ?User
    {
        return $this->user;
    }


    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }


    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;
        return $this;
    }

    public function getUserTitleInfo(): UsersInfosTitles
    {
        return $this->usersInfosTitles;
    }

    public function setUserTitleInfo(UsersInfosTitles $usersInfosTitles): self
    {
        $this->usersInfosTitles = $usersInfosTitles;
        return $this;
    }

}
