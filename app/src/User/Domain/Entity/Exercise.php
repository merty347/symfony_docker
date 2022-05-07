<?php

namespace App\User\Domain\Entity;

use App\User\Domain\Repository\ExerciseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExerciseRepository::class)
 */
class Exercise
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
    private $Name;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $Description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $VideoPath;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ImagePath;

    /**
     * @ORM\ManyToOne(targetEntity=Coach::class, inversedBy="exercises")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Author;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getVideoPath(): ?string
    {
        return $this->VideoPath;
    }

    public function setVideoPath(?string $VideoPath): self
    {
        $this->VideoPath = $VideoPath;

        return $this;
    }

    public function getImagePath(): ?string
    {
        return $this->ImagePath;
    }

    public function setImagePath(?string $ImagePath): self
    {
        $this->ImagePath = $ImagePath;

        return $this;
    }

    public function getAuthor(): ?Coach
    {
        return $this->Author;
    }

    public function setAuthor(?Coach $Author): self
    {
        $this->Author = $Author;

        return $this;
    }
}
