<?php

namespace FourViewture\Course\Domain\Model;

use FriendsOfTYPO3\TtAddress\Domain\Model\Address;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Course extends AbstractEntity
{
    protected string $number = '';
    protected string $additionalText = '';
    protected ?\DateTime $courseStartDate = null;
    protected ?\DateTime $courseEndDate = null;
    protected string $linkForAgb = '';
    protected string $courseType = '';
    protected string $courseDescription = '';
    protected string $courseIndex = '';
    protected string $costs = '';
    protected string $currency = '';
    protected string $costsText = '';
    protected string $availablePlaces = '';
    protected string $linkForRegistration = '';
    protected string $importId = '';
    protected string $importSource = '';
    /**
     * @var \FriendsOfTYPO3\TtAddress\Domain\Model\Address|null
     */
    protected $address = null;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category>
     */
    protected $categories;

    public function __construct()
    {
        $this->categories = new ObjectStorage();
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function setNumber(string $number): void
    {
        $this->number = $number;
    }

    public function getAdditionalText(): string
    {
        return $this->additionalText;
    }

    public function setAdditionalText(string $additionalText): void
    {
        $this->additionalText = $additionalText;
    }

    public function getCourseStartDate(): ?\DateTime
    {
        return $this->courseStartDate;
    }

    public function setCourseStartDate(?\DateTime $courseStartDate): void
    {
        $this->courseStartDate = $courseStartDate;
    }

    public function getCourseEndDate(): ?\DateTime
    {
        return $this->courseEndDate;
    }

    public function setCourseEndDate(?\DateTime $courseEndDate): void
    {
        $this->courseEndDate = $courseEndDate;
    }

    public function getLinkForAgb(): string
    {
        return $this->linkForAgb;
    }

    public function setLinkForAgb(string $linkForAgb): void
    {
        $this->linkForAgb = $linkForAgb;
    }

    public function getCourseType(): string
    {
        return $this->courseType;
    }

    public function setCourseType(string $courseType): void
    {
        $this->courseType = $courseType;
    }

    public function getCourseDescription(): string
    {
        return $this->courseDescription;
    }

    public function setCourseDescription(string $courseDescription): void
    {
        $this->courseDescription = $courseDescription;
    }

    public function getCourseIndex(): string
    {
        return $this->courseIndex;
    }

    public function setCourseIndex(string $courseIndex): void
    {
        $this->courseIndex = $courseIndex;
    }

    public function getCosts(): string
    {
        return $this->costs;
    }

    public function setCosts(string $costs): void
    {
        $this->costs = $costs;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    public function getCostsText(): string
    {
        return $this->costsText;
    }

    public function setCostsText(string $costsText): void
    {
        $this->costsText = $costsText;
    }

    public function getAvailablePlaces(): string
    {
        return $this->availablePlaces;
    }

    public function setAvailablePlaces(string $availablePlaces): void
    {
        $this->availablePlaces = $availablePlaces;
    }

    public function getLinkForRegistration(): string
    {
        return $this->linkForRegistration;
    }

    public function setLinkForRegistration(string $linkForRegistration): void
    {
        $this->linkForRegistration = $linkForRegistration;
    }

    public function getImportId(): string
    {
        return $this->importId;
    }

    public function setImportId(string $importId): void
    {
        $this->importId = $importId;
    }

    public function getImportSource(): string
    {
        return $this->importSource;
    }

    public function setImportSource(string $importSource): void
    {
        $this->importSource = $importSource;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): void
    {
        $this->address = $address;
    }

    public function isAvailable(): bool
    {
        if (empty($this->availablePlaces)) {
            return false;
        }
        if ($this->availablePlaces === 'Ausgebucht' || $this->availablePlaces === '0') {
            return false;
        }
        return true;
    }

    public function getCategories(): ObjectStorage
    {
        return $this->categories;
    }

    public function setCategories(ObjectStorage $categories): void
    {
        $this->categories = $categories;
    }
}
