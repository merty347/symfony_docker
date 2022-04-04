<?php

namespace App\Article\Domain\Entity;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Article\Domain\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;

class Article
{
    /**
     * @ORM\Entity(repositoryClass=ArticleRepository::class)
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 200)]
    private $title;

    #[ORM\Column(type: 'string', length: 9999)]
    private $content;

    #[ORM\Column(type: 'string', length: 200)]
    private $author;

    #[ORM\Column(type: 'datetime', length: 70)]
    private $date;

    #[ORM\Column(type: 'string', length: 255)]
    private $imagePath;

    // #[ORM\Column(type: 'bool')]
    // private $isPrivate;


    /**
     * @return mixed
     */
    public function getId() :?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author): void
    {
        $this->author = $author;
    }

    
    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }

    /**
     * @param mixed $imagePath
     */
    public function setImagePath($imagePath): void
    {
        $this->imagePath = $imagePath;
    }

}