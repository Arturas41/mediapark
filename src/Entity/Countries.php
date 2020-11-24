<?php

namespace App\Entity;

use App\Repository\CountriesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CountriesRepository::class)
 */
class Countries
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
    private $name;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private $code;

    /**
     * @ORM\OneToOne(targetEntity=SupportedCountries::class, mappedBy="country", cascade={"persist", "remove"})
     */
    private $supportedCountries;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getSupportedCountries(): ?SupportedCountries
    {
        return $this->supportedCountries;
    }

    public function setSupportedCountries(SupportedCountries $supportedCountries): self
    {
        $this->supportedCountries = $supportedCountries;

        // set the owning side of the relation if necessary
        if ($supportedCountries->getCountry() !== $this) {
            $supportedCountries->setCountry($this);
        }

        return $this;
    }
}
