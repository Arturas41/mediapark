<?php

namespace App\Entity;

use App\Repository\HolidayTypeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HolidayTypeRepository::class)
 */
class HolidayType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codeName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $shortDescription;

    /**
     * @ORM\ManyToOne(targetEntity=SupportedCountry::class, inversedBy="holidayType")
     */
    private $supportedCountry;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeName(): ?string
    {
        return $this->codeName;
    }

    public function setCodeName(string $codeName): self
    {
        $this->codeName = $codeName;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(string $shortDescription): self
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    public function getSupportedCountry(): ?SupportedCountry
    {
        return $this->supportedCountry;
    }

    public function setSupportedCountry(?SupportedCountry $supportedCountry): self
    {
        $this->supportedCountry = $supportedCountry;

        return $this;
    }

}
