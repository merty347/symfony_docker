<?php

namespace App\User\Domain\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\User\Domain\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
#[ApiResource]
class Article
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
    private $Title;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $Content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $CreatedAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $MainImagePath;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $Gallery = [];

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="Articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Author;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): self
    {
        $this->Title = $Title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->Content;
    }

    public function setContent(string $Content): self
    {
        $this->Content = $Content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(\DateTimeInterface $CreatedAt): self
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }

    public function getMainImagePath(): ?string
    {
        return $this->MainImagePath;
    }

    public function setMainImagePath(string $MainImagePath): self
    {
        $this->MainImagePath = $MainImagePath;

        return $this;
    }

    public function getGallery(): ?array
    {
        return $this->Gallery;
    }

    public function setGallery(?array $Gallery): self
    {
        $this->Gallery = $Gallery;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->Author;
    }

    public function setAuthor(?User $Author): self
    {
        $this->Author = $Author;

        return $this;
    }
}
