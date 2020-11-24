<?php

namespace App\Entity;

use App\Repository\HolidayTypesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HolidayTypesRepository::class)
 */
class HolidayTypes
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
    private $CodeName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ShortDescription;

    public function getCodeName(): ?string
    {
        return $this->CodeName;
    }

    public function setCodeName(string $CodeName): self
    {
        $this->CodeName = $CodeName;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->ShortDescription;
    }

    public function setShortDescription(string $ShortDescription): self
    {
        $this->ShortDescription = $ShortDescription;

        return $this;
    }

}
