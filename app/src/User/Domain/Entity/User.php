<?php

namespace App\User\Domain\Entity;

use App\User\Domain\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Article\Domain\Entity\Article;
use App\Model\MyUserInterface as ModelUserInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ApiResource]
class User implements UserInterface, PasswordAuthenticatedUserInterface, ModelUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private ?string $email;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\Column(type: 'string')]
    private string $password;

    #[ORM\Column(type: 'string', length: 180)]
    private ?string $username;

    #[ORM\Column(type: "boolean")]
    private $coach;

    #[ORM\Column(type: "boolean")]
    private $editor;

    // #[ORM\ManyToMany(targetEntity: Article::class, mappedBy:"users")]
    // private $articles;

    // public function __construct()
    // {
    //     $this->articles = new ArrayCollection();

    // }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        
        return $this;
    }

    public function isCoach(): bool
    {
        return $this->coach;
    }
    public function setCoach(bool $coach): self
    {
        $this->coach = $coach;
        return $this;
    }

    public function isEditor(): bool
    {
        return $this->editor;
    }
    public function setEditor(bool $editor): self
    {
        $this->editor = $editor;
        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }


    // /**
    //  * @return Collection|Article[]
    //  */
    // public function getArticles() : Collection
    // {
    //     return $this->articles;
    // }

    // public function addArticle(Article $article) : self
    // {
    //     if (!$this-> articles->contains($article))
    //     {
    //         $this->articles[] = $article;
    //         $article->addUser($this);
    //     }
    //     return $this;
    // }

    // public function removeArticle(Article $article) : self
    // {
    //     if ($this->articles->removeElement($article))
    //     {
    //         $article->removeUser($this);
    //     }
    //     return $this;
    // }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function setType(User $user)
    {
        // if ($user->isCoach())
        // {

        // }
    }
}
