<?php

namespace App\Coach\Domain\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Coach\Domain\Repository\CoachRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoachRepository::class)]
#[ApiResource]
class Coach
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 200)]
    private $discipline;

    #[ORM\Column(type: 'string', length: 180)]
    private $FirstName;

    #[ORM\Column(type: 'string', length: 250)]
    private $LastName;

    #[ORM\Column(type: 'string', length: 200, nullable: true)]
    private $Team;

    #[ORM\Column(type: 'string', length: 180)]
    private $LicenseNumber;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDiscipline(): ?string
    {
        return $this->discipline;
    }

    public function setDiscipline(string $discipline): self
    {
        $this->discipline = $discipline;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->FirstName;
    }

    public function setFirstName(string $FirstName): self
    {
        $this->FirstName = $FirstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->LastName;
    }

    public function setLastName(string $LastName): self
    {
        $this->LastName = $LastName;

        return $this;
    }

    public function getTeam(): ?string
    {
        return $this->Team;
    }

    public function setTeam(?string $Team): self
    {
        $this->Team = $Team;

        return $this;
    }

    public function getLicenseNumber(): ?string
    {
        return $this->LicenseNumber;
    }

    public function setLicenseNumber(string $LicenseNumber): self
    {
        $this->LicenseNumber = $LicenseNumber;

        return $this;
    }
}
