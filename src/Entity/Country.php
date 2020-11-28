<?php

namespace App\Entity;

use App\Repository\CountryRepository;
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
     * @ORM\OneToOne(targetEntity=SupportedCountry::class, mappedBy="country", cascade={"persist", "remove"})
     */
    private $supportedCountry;

    public function __construct()
    {
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

    public function getSupportedCountry(): ?SupportedCountry
    {
        return $this->supportedCountry;
    }

    public function setSupportedCountry(SupportedCountry $supportedCountry): self
    {
        $this->supportedCountry = $supportedCountry;

        // set the owning side of the relation if necessary
        if ($supportedCountry->getCountry() !== $this) {
            $supportedCountry->setCountry($this);
        }

        return $this;
    }

}
