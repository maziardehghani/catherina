<?php

namespace App\Entities;


use App\Enums\ContractTypes;
use App\Enums\DocumentTypes;
use App\Traits\HasStatus;
use App\Traits\HasTimeStamp;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;



#[ORM\Entity]
#[ORM\Table(name: 'farabourse_projects')]
class FarabourseProject
{
    use HasTimeStamp;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $traceCode = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $persianName = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $englishName = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $persianSymbol = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $englishSymbol = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $industryGroup = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $subIndustryGroup = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 15)]
    private ?float $unitPrice = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $totalUnit = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $companyUnits = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 20)]
    private ?float $totalAmounts = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $crowdFundingId = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $settlementDescription = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $crowdFundingDescription = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 15)]
    private ?float $minimumRequirePrice = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 15)]
    private ?float $realPersonMinimumAvailablePrice = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 15)]
    private ?float $realPersonMaximumAvailablePrice = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 15)]
    private ?float $legalPersonMinimumAvailablePrice = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 15)]
    private ?float $legalPersonMaximumAvailablePrice = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $underwritingDuration = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $suggestedUnderwritingStartDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $suggestedUnderwritingEndDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $approvedUnderwritingStartDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $approvedUnderwritingEndDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $projectStartDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $projectEndDate = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $projectReportingTypeDescription = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $projectStatusDescription = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $projectStatusId = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $numberOfFinanceProvider = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 20)]
    private ?float $sumOfFoundingProvided = null;


    // Getter and Setter for id
    public function getId(): ?int
    {
        return $this->id;
    }

// Getter and Setter for traceCode
    public function getTraceCode(): ?string
    {
        return $this->traceCode;
    }

    public function setTraceCode(?string $traceCode): self
    {
        $this->traceCode = $traceCode;
        return $this;
    }

// Getter and Setter for persianName
    public function getPersianName(): ?string
    {
        return $this->persianName;
    }

    public function setPersianName(?string $persianName): self
    {
        $this->persianName = $persianName;
        return $this;
    }

// Getter and Setter for englishName
    public function getEnglishName(): ?string
    {
        return $this->englishName;
    }

    public function setEnglishName(?string $englishName): self
    {
        $this->englishName = $englishName;
        return $this;
    }

// Getter and Setter for persianSymbol
    public function getPersianSymbol(): ?string
    {
        return $this->persianSymbol;
    }

    public function setPersianSymbol(?string $persianSymbol): self
    {
        $this->persianSymbol = $persianSymbol;
        return $this;
    }

// Getter and Setter for englishSymbol
    public function getEnglishSymbol(): ?string
    {
        return $this->englishSymbol;
    }

    public function setEnglishSymbol(?string $englishSymbol): self
    {
        $this->englishSymbol = $englishSymbol;
        return $this;
    }

// Getter and Setter for industryGroup
    public function getIndustryGroup(): ?string
    {
        return $this->industryGroup;
    }

    public function setIndustryGroup(?string $industryGroup): self
    {
        $this->industryGroup = $industryGroup;
        return $this;
    }

// Getter and Setter for subIndustryGroup
    public function getSubIndustryGroup(): ?string
    {
        return $this->subIndustryGroup;
    }

    public function setSubIndustryGroup(?string $subIndustryGroup): self
    {
        $this->subIndustryGroup = $subIndustryGroup;
        return $this;
    }

// Getter and Setter for unitPrice
    public function getUnitPrice(): ?float
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(?float $unitPrice): self
    {
        $this->unitPrice = $unitPrice;
        return $this;
    }

// Getter and Setter for totalUnit
    public function getTotalUnit(): ?int
    {
        return $this->totalUnit;
    }

    public function setTotalUnit(?int $totalUnit): self
    {
        $this->totalUnit = $totalUnit;
        return $this;
    }

// Getter and Setter for companyUnits
    public function getCompanyUnits(): ?int
    {
        return $this->companyUnits;
    }

    public function setCompanyUnits(?int $companyUnits): self
    {
        $this->companyUnits = $companyUnits;
        return $this;
    }

// Getter and Setter for totalAmounts
    public function getTotalAmounts(): ?float
    {
        return $this->totalAmounts;
    }

    public function setTotalAmounts(?float $totalAmounts): self
    {
        $this->totalAmounts = $totalAmounts;
        return $this;
    }

// Getter and Setter for crowdFundingId
    public function getCrowdFundingId(): ?int
    {
        return $this->crowdFundingId;
    }

    public function setCrowdFundingId(?int $crowdFundingId): self
    {
        $this->crowdFundingId = $crowdFundingId;
        return $this;
    }

// Getter and Setter for settlementDescription
    public function getSettlementDescription(): ?string
    {
        return $this->settlementDescription;
    }

    public function setSettlementDescription(?string $settlementDescription): self
    {
        $this->settlementDescription = $settlementDescription;
        return $this;
    }

// Getter and Setter for crowdFundingDescription
    public function getCrowdFundingDescription(): ?string
    {
        return $this->crowdFundingDescription;
    }

    public function setCrowdFundingDescription(?string $crowdFundingDescription): self
    {
        $this->crowdFundingDescription = $crowdFundingDescription;
        return $this;
    }

// Getter and Setter for minimumRequirePrice
    public function getMinimumRequirePrice(): ?float
    {
        return $this->minimumRequirePrice;
    }

    public function setMinimumRequirePrice(?float $minimumRequirePrice): self
    {
        $this->minimumRequirePrice = $minimumRequirePrice;
        return $this;
    }

// Getter and Setter for realPersonMinimumAvailablePrice
    public function getRealPersonMinimumAvailablePrice(): ?float
    {
        return $this->realPersonMinimumAvailablePrice;
    }

    public function setRealPersonMinimumAvailablePrice(?float $realPersonMinimumAvailablePrice): self
    {
        $this->realPersonMinimumAvailablePrice = $realPersonMinimumAvailablePrice;
        return $this;
    }

// Getter and Setter for realPersonMaximumAvailablePrice
    public function getRealPersonMaximumAvailablePrice(): ?float
    {
        return $this->realPersonMaximumAvailablePrice;
    }

    public function setRealPersonMaximumAvailablePrice(?float $realPersonMaximumAvailablePrice): self
    {
        $this->realPersonMaximumAvailablePrice = $realPersonMaximumAvailablePrice;
        return $this;
    }

// Getter and Setter for legalPersonMinimumAvailablePrice
    public function getLegalPersonMinimumAvailablePrice(): ?float
    {
        return $this->legalPersonMinimumAvailablePrice;
    }

    public function setLegalPersonMinimumAvailablePrice(?float $legalPersonMinimumAvailablePrice): self
    {
        $this->legalPersonMinimumAvailablePrice = $legalPersonMinimumAvailablePrice;
        return $this;
    }

// Getter and Setter for legalPersonMaximumAvailablePrice
    public function getLegalPersonMaximumAvailablePrice(): ?float
    {
        return $this->legalPersonMaximumAvailablePrice;
    }

    public function setLegalPersonMaximumAvailablePrice(?float $legalPersonMaximumAvailablePrice): self
    {
        $this->legalPersonMaximumAvailablePrice = $legalPersonMaximumAvailablePrice;
        return $this;
    }

// Getter and Setter for underwritingDuration
    public function getUnderwritingDuration(): ?int
    {
        return $this->underwritingDuration;
    }

    public function setUnderwritingDuration(?int $underwritingDuration): self
    {
        $this->underwritingDuration = $underwritingDuration;
        return $this;
    }

// Getter and Setter for suggestedUnderwritingStartDate
    public function getSuggestedUnderwritingStartDate(): ?DateTimeInterface
    {
        return $this->suggestedUnderwritingStartDate;
    }

    public function setSuggestedUnderwritingStartDate(?DateTimeInterface $suggestedUnderwritingStartDate): self
    {
        $this->suggestedUnderwritingStartDate = $suggestedUnderwritingStartDate;
        return $this;
    }

// Getter and Setter for suggestedUnderwritingEndDate
    public function getSuggestedUnderwritingEndDate(): ?DateTimeInterface
    {
        return $this->suggestedUnderwritingEndDate;
    }

    public function setSuggestedUnderwritingEndDate(?DateTimeInterface $suggestedUnderwritingEndDate): self
    {
        $this->suggestedUnderwritingEndDate = $suggestedUnderwritingEndDate;
        return $this;
    }

// Getter and Setter for approvedUnderwritingStartDate
    public function getApprovedUnderwritingStartDate(): ?DateTimeInterface
    {
        return $this->approvedUnderwritingStartDate;
    }

    public function setApprovedUnderwritingStartDate(?DateTimeInterface $approvedUnderwritingStartDate): self
    {
        $this->approvedUnderwritingStartDate = $approvedUnderwritingStartDate;
        return $this;
    }

// Getter and Setter for approvedUnderwritingEndDate
    public function getApprovedUnderwritingEndDate(): ?DateTimeInterface
    {
        return $this->approvedUnderwritingEndDate;
    }

    public function setApprovedUnderwritingEndDate(?DateTimeInterface $approvedUnderwritingEndDate): self
    {
        $this->approvedUnderwritingEndDate = $approvedUnderwritingEndDate;
        return $this;
    }

// Getter and Setter for projectStartDate
    public function getProjectStartDate(): ?DateTimeInterface
    {
        return $this->projectStartDate;
    }

    public function setProjectStartDate(?DateTimeInterface $projectStartDate): self
    {
        $this->projectStartDate = $projectStartDate;
        return $this;
    }

// Getter and Setter for projectEndDate
    public function getProjectEndDate(): ?DateTimeInterface
    {
        return $this->projectEndDate;
    }

    public function setProjectEndDate(?DateTimeInterface $projectEndDate): self
    {
        $this->projectEndDate = $projectEndDate;
        return $this;
    }

// Getter and Setter for projectReportingTypeDescription
    public function getProjectReportingTypeDescription(): ?string
    {
        return $this->projectReportingTypeDescription;
    }

    public function setProjectReportingTypeDescription(?string $projectReportingTypeDescription): self
    {
        $this->projectReportingTypeDescription = $projectReportingTypeDescription;
        return $this;
    }

// Getter and Setter for projectStatusDescription
    public function getProjectStatusDescription(): ?string
    {
        return $this->projectStatusDescription;
    }

    public function setProjectStatusDescription(?string $projectStatusDescription): self
    {
        $this->projectStatusDescription = $projectStatusDescription;
        return $this;
    }

// Getter and Setter for projectStatusId
    public function getProjectStatusId(): ?int
    {
        return $this->projectStatusId;
    }

    public function setProjectStatusId(?int $projectStatusId): self
    {
        $this->projectStatusId = $projectStatusId;
        return $this;
    }

// Getter and Setter for numberOfFinanceProvider
    public function getNumberOfFinanceProvider(): ?int
    {
        return $this->numberOfFinanceProvider;
    }

    public function setNumberOfFinanceProvider(?int $numberOfFinanceProvider): self
    {
        $this->numberOfFinanceProvider = $numberOfFinanceProvider;
        return $this;
    }

// Getter and Setter for sumOfFoundingProvided
    public function getSumOfFoundingProvided(): ?float
    {
        return $this->sumOfFoundingProvided;
    }

    public function setSumOfFoundingProvided(?float $sumOfFoundingProvided): self
    {
        $this->sumOfFoundingProvided = $sumOfFoundingProvided;
        return $this;
    }


}
