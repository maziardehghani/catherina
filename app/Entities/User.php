<?php

namespace App\Entities;


use App\Enums\UserTypes;
use App\Repositories\User\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Illuminate\Support\Facades\Hash;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $family = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $mobile = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $createdAt = null;


    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $updatedAt = null;


    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $is_sejami = false;


    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $is_private_investor = false;

    #[ORM\Column(type: Types::INTEGER)]
    private int $status_id = 1;


    #[ORM\Column(type: Types::STRING)]
    private ?string $bio = null;


    #[ORM\Column(type: Types::STRING)]
    private string $password;


    #[ORM\Column(type: Types::ENUM)]
    private ?UserTypes $type = null;

    #[ORM\OneToMany(targetEntity: UsersInfosValues::class, mappedBy: 'user', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $usersInfosValues;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getFamily(): ?string
    {
        return $this->family;
    }

    public function setFamily(string $family): static
    {
        $this->family = $family;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(string $mobile): static
    {
        $this->mobile = $mobile;

        return $this;
    }

    public function getIsSejami(): bool
    {
        return $this->is_sejami;
    }

    public function setIsSejami(bool $is_sejami): self
    {
        $this->is_sejami = $is_sejami;
        return $this;
    }

    // Getter and Setter for $is_private_investor
    public function getIsPrivateInvestor(): bool
    {
        return $this->is_private_investor;
    }

    public function setIsPrivateInvestor(bool $is_private_investor): self
    {
        $this->is_private_investor = $is_private_investor;
        return $this;
    }

    // Getter and Setter for $status_id
    public function getStatusId(): int
    {
        return $this->status_id;
    }

    public function setStatusId(int $status_id): self
    {
        $this->status_id = $status_id;
        return $this;
    }

    // Getter and Setter for $bio
    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): self
    {
        $this->bio = $bio;
        return $this;
    }

    // Getter and Setter for $password
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = Hash::make($password);
        return $this;
    }

    // Getter and Setter for $type
    public function getType(): ?UserTypes
    {
        return $this->type;
    }

    public function setType(UserTypes $type): self
    {
        $this->type = $type;
        return $this;
    }


    public function setUsersInfosValues(Collection $usersInfosValues): self
    {
        $this->usersInfosValues = $usersInfosValues;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }
    #[ORM\PrePersist]

    public function setCreatedAt(): void
    {
        $this->createdAt = new \DateTime();

    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    #[ORM\PreUpdate]
    public function setUpdatedAt(): void
    {
        $this->updatedAt = new \DateTime();;

    }

    public function getUsersInfosValues(): Collection
    {
        return $this->usersInfosValues;
    }

    public function addUsersInfosValues(UsersInfosValues $usersInfosValues): void
    {
        if (!$this->usersInfosValues->contains($usersInfosValues)) {
            $this->usersInfosValues->add($usersInfosValues);
            $usersInfosValues->setUser($this);
        }
    }


    public function getNationalId(): ?string
    {
        return $this->getInfo('national_id');
    }


//    public function privateInvestor():string
//    {
//        return $this->is_private_investor ? 'خصوصی است' : 'خصوصی نیست');
//    }

    public function getEconomicCode()
    {
        return $this->getInfo('economic_code');
    }

    public function getManagerName()
    {
        return $this->getInfo('manager_name');
    }

    public function getManagerNationalId()
    {
        return $this->getInfo('manager_national_id');
    }

    public function getPostalCode()
    {
        return $this->getInfo('postal_code');
    }

    public function getCompanyName()
    {
        return $this->getInfo('company_name');
    }

    public function getFatherName()
    {
        return $this->getInfo('father_name');
    }

    public function getTradingCode()
    {
        return $this->getInfo('trading_code');
    }

    public function getSheba()
    {
        return $this->getInfo('sheba');
    }

    public function getBankName()
    {
        return $this->getInfo('bank_name');
    }

    public function getAccountType()
    {
        return $this->getInfo('account_type');
    }

    public function getAccountNumber()
    {
        return $this->getInfo('account_number');
    }

    public function getSerialNumber()
    {
        return $this->getInfo('serial_number');
    }

    public function getAddress()
    {
        return $this->getInfo('address');
    }

    public function getPlaceOfBirth()
    {
        return $this->getInfo('place_of_birth');
    }

    public function getPlaceOfIssue()
    {
        return $this->getInfo('place_of_issue');
    }

    public function getPhoneNumber()
    {
        return $this->getInfo('phone_number');
    }

    public function getFax()
    {
        return $this->getInfo('fax');
    }

    public function getBirthDate()
    {
        return $this->getInfo('birth_date');
    }

    public function getShebaExceptAyandehBank()
    {
        return $this->getBankName() != 'بانک آینده' ? $this->getSheba() : $this->getAccountNumber();
    }

    public function getSejamStatus(): string
    {
        return $this->getIsSejami() ? 'سجامی' : 'ندارد';
    }

//    public function getPersianStatus()
//    {
//        return $this->getStatusId()?->persianTitle);
//    }

//    public function getPersianType()
//    {
//        return self::$persianTypes[$this->type]);
//    }

//    public function getMediasUrl()
//    {
//        return $this->medias?->url;
//    }

    public function getUserName()
    {
        return $this->getType() == 'real' ? $this->getName() . ' ' . $this->getFamily() : $this->getCompanyName();
    }

    public function getGender()
    {
        return $this->getInfo('gender');
    }

    public function getGenderName(): string
    {
        return $this->getGender() == 'male' ? 'مرد' : 'زن';
    }

    public function getRegisterCode()
    {
        return $this->getInfo('register_code');
    }


    public function getInfo($title)
    {
        foreach ($this->usersInfosValues as $userInfosValue) {
            if ($userInfosValue->getUserTitleInfo()->getTitle() === $title) {
                return $userInfosValue->getValue();
            }
        }
    }


}
