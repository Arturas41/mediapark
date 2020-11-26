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
     * @ORM\Column(type="date")
     */
    private $fromDate;

    /**
     * @ORM\Column(type="date")
     */
    private $toDate;

    /**
     * @ORM\OneToMany(targetEntity=HolidayType::class, mappedBy="supportedCountry")
     */
    private $holidayTypes;

    /**
     * @ORM\ManyToOne(targetEntity=Country::class, inversedBy="supportedCountries")
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

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

}
