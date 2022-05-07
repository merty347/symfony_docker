<?php

namespace App\User\Domain\Entity;

use App\User\Domain\Repository\CoachRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CoachRepository::class)
 */
class Coach
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $license;

    // /**
    //  * @ORM\Column(type="string", length=255)
    //  */
    // private $team;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $club;

    /**
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="Coach", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Exercise::class, mappedBy="Author")
     */
    private $exercises;

    public function __construct()
    {
        $this->exercises = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLicense(): ?string
    {
        return $this->license;
    }

    public function setLicense(string $license): self
    {
        $this->license = $license;

        return $this;
    }

    // public function getTeam(): ?string
    // {
    //     return $this->team;
    // }

    // public function setTeam(string $team): self
    // {
    //     $this->team = $team;

    //     return $this;
    // }

    public function getClub(): ?string
    {
        return $this->club;
    }

    public function setClub(string $club): self
    {
        $this->club = $club;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setCoach(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getCoach() !== $this) {
            $user->setCoach($this);
        }

        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Exercise>
     */
    public function getExercises(): Collection
    {
        return $this->exercises;
    }

    public function addExercise(Exercise $exercise): self
    {
        if (!$this->exercises->contains($exercise)) {
            $this->exercises[] = $exercise;
            $exercise->setAuthor($this);
        }

        return $this;
    }

    public function removeExercise(Exercise $exercise): self
    {
        if ($this->exercises->removeElement($exercise)) {
            // set the owning side to null (unless already changed)
            if ($exercise->getAuthor() === $this) {
                $exercise->setAuthor(null);
            }
        }

        return $this;
    }
}
