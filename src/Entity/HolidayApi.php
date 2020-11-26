<?php

namespace App\Entity;

use App\Repository\HolidayApiRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=HolidayApiRepository::class)
 * @UniqueEntity("name")
 * @UniqueEntity("url")
 */
class HolidayApi
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
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\OneToMany(targetEntity=SupportedCountry::class, mappedBy="holidayApi")
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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

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
            $supportedCountry->setHolidayApi($this);
        }

        return $this;
    }

    public function removeSupportedCountry(SupportedCountry $supportedCountry): self
    {
        if ($this->supportedCountries->removeElement($supportedCountry)) {
            // set the owning side to null (unless already changed)
            if ($supportedCountry->getHolidayApi() === $this) {
                $supportedCountry->setHolidayApi(null);
            }
        }

        return $this;
    }
}
