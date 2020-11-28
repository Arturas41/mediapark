<?php

namespace App\Entity;

use App\Repository\SupportedCountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SupportedCountryRepository::class)
 */
class SupportedCountry
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=HolidayType::class, mappedBy="supportedCountry")
     */
    private $holidayTypes;

    /**
     * @ORM\Column(type="integer")
     */
    private $fromDateYear;

    /**
     * @ORM\Column(type="integer")
     */
    private $fromDateMonth;

    /**
     * @ORM\Column(type="integer")
     */
    private $fromDateDay;

    /**
     * @ORM\Column(type="integer")
     */
    private $toDateYear;

    /**
     * @ORM\Column(type="integer")
     */
    private $toDateMonth;

    /**
     * @ORM\Column(type="integer")
     */
    private $toDateDay;

    /**
     * @ORM\OneToOne(targetEntity=Country::class, inversedBy="supportedCountry", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $country;

    public function __construct()
    {
        $this->holidayTypes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|HolidayType[]
     */
    public function getHolidayTypes(): Collection
    {
        return $this->holidayTypes;
    }

    public function addHolidayType(HolidayType $holidayType): self
    {
        if (!$this->holidayTypes->contains($holidayType)) {
            $this->holidayTypes[] = $holidayType;
            $holidayType->setSupportedCountry($this);
        }

        return $this;
    }

    public function removeHolidayType(HolidayType $holidayType): self
    {
        if ($this->holidayTypes->removeElement($holidayType)) {
            // set the owning side to null (unless already changed)
            if ($holidayType->getSupportedCountry() === $this) {
                $holidayType->setSupportedCountry(null);
            }
        }

        return $this;
    }

    public function getFromDateYear(): ?int
    {
        return $this->fromDateYear;
    }

    public function setFromDateYear(int $fromDateYear): self
    {
        $this->fromDateYear = $fromDateYear;

        return $this;
    }

    public function getFromDateMonth(): ?int
    {
        return $this->fromDateMonth;
    }

    public function setFromDateMonth(int $fromDateMonth): self
    {
        $this->fromDateMonth = $fromDateMonth;

        return $this;
    }

    public function getFromDateDay(): ?int
    {
        return $this->fromDateDay;
    }

    public function setFromDateDay(int $fromDateDay): self
    {
        $this->fromDateDay = $fromDateDay;

        return $this;
    }

    public function getToDateYear(): ?int
    {
        return $this->toDateYear;
    }

    public function setToDateYear(int $toDateYear): self
    {
        $this->toDateYear = $toDateYear;

        return $this;
    }

    public function getToDateMonth(): ?int
    {
        return $this->toDateMonth;
    }

    public function setToDateMonth(int $toDateMonth): self
    {
        $this->toDateMonth = $toDateMonth;

        return $this;
    }

    public function getToDateDay(): ?int
    {
        return $this->toDateDay;
    }

    public function setToDateDay(int $toDateDay): self
    {
        $this->toDateDay = $toDateDay;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(Country $country): self
    {
        $this->country = $country;

        return $this;
    }

}
