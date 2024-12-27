<?php

namespace App\Entities;


use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity]
#[ORM\Table(name: 'users_infos_values')]
class UsersInfosValues
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'usersInfosValues')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;


    #[ORM\OneToOne(targetEntity: UsersInfosTitles::class, inversedBy: 'usersInfosValues')]
    #[ORM\JoinColumn(nullable: false)]
    private UsersInfosTitles $userInfoTitle ;


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



    public function getValue(): ?string
    {
        return $this->value;
    }


    public function getUserTitleInfo(): UsersInfosTitles
    {
        return $this->userInfoTitle;
    }


}
