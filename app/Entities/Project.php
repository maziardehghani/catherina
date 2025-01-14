<?php

namespace App\Entities;


use App\Repositories\City\CityRepository;
use App\Repositories\Project\ProjectRepository;
use App\Repositories\User\UserRepository;
use App\Traits\HasStatus;
use App\Traits\HasTimeStamp;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
#[ORM\Table(name: 'projects')]
class Project
{
    use HasTimeStamp,HasStatus;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(targetEntity: FarabourseProject::class, mappedBy: 'project')]
    private FarabourseProject $farabourseProject;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'projects')]
    #[ORM\JoinColumn(referencedColumnName: 'id', nullable: false, fieldName: 'user_id')]
    private User $user;


    #[ORM\OneToMany(targetEntity: Order::class, mappedBy: 'project')]
    private Collection $orders;

    #[ORM\ManyToOne(targetEntity: Warranty::class, inversedBy: 'warranty_id')]
    #[ORM\JoinColumn(referencedColumnName: 'id', nullable: true, fieldName: 'warranty_id')]
    private Warranty $warranty;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::STRING, length: 255, unique: true)]
    private ?string $slug = null;

    #[ORM\ManyToOne(targetEntity: City::class, inversedBy: 'projects')]
    #[ORM\JoinColumn(referencedColumnName: 'id', nullable: false, fieldName: 'city_id')]
    private City $city;

    #[ORM\Column(type: Types::DECIMAL, nullable: true,  precision: 5, scale: 2)]
    private ?float $percent = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $fundingPeriod = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $projectIntro = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $expertOpinion = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $companyIntro = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $projectRisks = null;

// Getter for warranty
    public function getWarranty(): Warranty
    {
        return $this->warranty;
    }

// Setter for warranty
    public function setWarranty(Warranty $warranty): self
    {
        $this->warranty = $warranty;
        return $this;
    }

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $warrantyDetails = null;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $participationGenerated = false;

    // Getters and Setters will go here


    // Getter and Setter for id
    public function getId(): ?int
    {
        return $this->id;
    }

// Getter and Setter for title
    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;
        return $this;
    }

// Getter and Setter for slug
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

// Getter and Setter for city
    public function getCity(): City
    {
        return $this->city;
    }

    public function setCity(int|City $city): self
    {
        if (is_int($city)) {
            $city = resolve(CityRepository::class)->find($city);
        }
        $this->city = $city;
        return $this;
    }

// Getter and Setter for percent
    public function getPercent(): ?float
    {
        return $this->percent;
    }

    public function setPercent(?float $percent): self
    {
        $this->percent = $percent;
        return $this;
    }

// Getter and Setter for fundingPeriod
    public function getFundingPeriod(): ?int
    {
        return $this->fundingPeriod;
    }

    public function setFundingPeriod(?int $fundingPeriod): self
    {
        $this->fundingPeriod = $fundingPeriod;
        return $this;
    }

// Getter and Setter for projectIntro
    public function getProjectIntro(): ?string
    {
        return $this->projectIntro;
    }

    public function setProjectIntro(?string $projectIntro): self
    {
        $this->projectIntro = $projectIntro;
        return $this;
    }

// Getter and Setter for expertOpinion
    public function getExpertOpinion(): ?string
    {
        return $this->expertOpinion;
    }

    public function setExpertOpinion(?string $expertOpinion): self
    {
        $this->expertOpinion = $expertOpinion;
        return $this;
    }

// Getter and Setter for companyIntro
    public function getCompanyIntro(): ?string
    {
        return $this->companyIntro;
    }

    public function setCompanyIntro(?string $companyIntro): self
    {
        $this->companyIntro = $companyIntro;
        return $this;
    }

// Getter and Setter for projectRisks
    public function getProjectRisks(): ?string
    {
        return $this->projectRisks;
    }

    public function setProjectRisks(?string $projectRisks): self
    {
        $this->projectRisks = $projectRisks;
        return $this;
    }


// Getter and Setter for warrantyDetails
    public function getWarrantyDetails(): ?string
    {
        return $this->warrantyDetails;
    }

    public function setWarrantyDetails(?string $warrantyDetails): self
    {
        $this->warrantyDetails = $warrantyDetails;
        return $this;
    }

// Getter and Setter for participationGenerated
    public function isParticipationGenerated(): bool
    {
        return $this->participationGenerated;
    }

    public function setParticipationGenerated(bool $participationGenerated): self
    {
        $this->participationGenerated = $participationGenerated;
        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getFarabourseProject(): ?FarabourseProject
    {
        return $this->farabourseProject;
    }

    public function setFarabourseProject(FarabourseProject $farabourseProject): self
    {
        $this->farabourseProject = $farabourseProject;
        return $this;
    }

    public function setUser(int|User $user): self
    {
        if(is_int($user)){
            $user = resolve(UserRepository::class)->find($user);
        }

        $this->user = $user;
        return $this;
    }

    public function getFarabourseTotalAmounts()
    {
        return $this->farabourseProject->getTotalAmounts();
    }

    public function getMinimumAmount()
    {
        return $this->farabourseProject->getMinimumRequirePrice();
    }

    public function getRealPersonMinimAmount()
    {
        return $this->farabourseProject->getRealPersonMinimumAvailablePrice();
    }

    public function getRealPersonMaximAmount()
    {
        return $this->farabourseProject->getRealPersonMaximumAvailablePrice();
    }

    public function getLegalPersonMinimAmount()
    {
        return $this->farabourseProject->getLegalPersonMinimumAvailablePrice();
    }


    public function getLegalPersonMaximAmount()
    {
        return $this->farabourseProject->getLegalPersonMaximumAvailablePrice();
    }



}
