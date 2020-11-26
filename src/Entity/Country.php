<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CountryRepository::class)
 */
class Country
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
     * @ORM\OneToMany(targetEntity=SupportedCountry::class, mappedBy="country")
     */
    private $supportedCountries;

    public function __construct()
    {
        $this->supportedCountries = new ArrayCollection();
    }

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

    /**
     * @return Collection|SupportedCountry[]
     */
    public function getSupportedCountries(): Collection
    {
        return $this->supportedCountries;
    }

    public function addSupportedCountry(SupportedCountry $supportedCountry): self
    {
        if (!$this->supportedCountries->contains($supportedCountry)) {
            $this->supportedCountries[] = $supportedCountry;
            $supportedCountry->setCountry($this);
        }

        return $this;
    }

    public function removeSupportedCountry(SupportedCountry $supportedCountry): self
    {
        if ($this->supportedCountries->removeElement($supportedCountry)) {
            // set the owning side to null (unless already changed)
            if ($supportedCountry->getCountry() === $this) {
                $supportedCountry->setCountry(null);
            }
        }

        return $this;
    }

}
