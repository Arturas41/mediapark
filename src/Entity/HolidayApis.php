<?php

namespace App\Entity;

use App\Repository\HolidayApisRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=HolidayApisRepository::class)
 * @UniqueEntity("name")
 * @UniqueEntity("url")
 */
class HolidayApis
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
     * @ORM\OneToOne(targetEntity=SupportedCountries::class, mappedBy="holidayApi", cascade={"persist", "remove"})
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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

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
        if ($supportedCountries->getHolidayApi() !== $this) {
            $supportedCountries->setHolidayApi($this);
        }

        return $this;
    }
}
