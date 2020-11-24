<?php

namespace App\Entity;

use App\Repository\SupportedCountriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SupportedCountriesRepository::class)
 */
class SupportedCountries
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Countries::class, inversedBy="supportedCountries", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $country;

    /**
     * @ORM\OneToOne(targetEntity=HolidayApis::class, inversedBy="supportedCountries", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $holidayApi;

    /**
     * @ORM\Column(type="date")
     */
    private $fromDate;

    /**
     * @ORM\Column(type="date")
     */
    private $toDate;

    /**
     * @ORM\OneToMany(targetEntity=HolidayTypes::class, mappedBy="supportedCountries")
     */
    private $holidayTypes;

    public function __construct()
    {
        $this->holidayTypes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCountry(): ?Countries
    {
        return $this->country;
    }

    public function setCountry(Countries $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getHolidayApi(): ?HolidayApis
    {
        return $this->holidayApi;
    }

    public function setHolidayApi(HolidayApis $holidayApi): self
    {
        $this->holidayApi = $holidayApi;

        return $this;
    }

    public function getFromDate(): ?\DateTimeInterface
    {
        return $this->fromDate;
    }

    public function setFromDate(\DateTimeInterface $fromDate): self
    {
        $this->fromDate = $fromDate;

        return $this;
    }

    public function getToDate(): ?\DateTimeInterface
    {
        return $this->toDate;
    }

    public function setToDate(\DateTimeInterface $toDate): self
    {
        $this->toDate = $toDate;

        return $this;
    }

    /**
     * @return Collection|HolidayTypes[]
     */
    public function getHolidayTypes(): Collection
    {
        return $this->holidayTypes;
    }

    public function addHolidayType(HolidayTypes $holidayType): self
    {
        if (!$this->holidayTypes->contains($holidayType)) {
            $this->holidayTypes[] = $holidayType;
            $holidayType->setSupportedCountries($this);
        }

        return $this;
    }

    public function removeHolidayType(HolidayTypes $holidayType): self
    {
        if ($this->holidayTypes->removeElement($holidayType)) {
            // set the owning side to null (unless already changed)
            if ($holidayType->getSupportedCountries() === $this) {
                $holidayType->setSupportedCountries(null);
            }
        }

        return $this;
    }
}
