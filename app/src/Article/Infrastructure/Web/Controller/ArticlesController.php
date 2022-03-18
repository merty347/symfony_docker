<?php

namespace App\Article\Infrastructure\Web\Controller;

use App\Article\Domain\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\User\Domain\Entity\User;

class ArticlesController extends AbstractController
{
    public function __construct()
    {
        
    }

    //tworzenie nowego artykułu

     public function CreateArticle(User $user)
     {
            $article = new Article();
            //sprawdzanie czy user to ten co zalogowany
            

            //dodawanie artykułu do bazy danych:

            //przypisywanie użytkownika do nowo dodanego artykułu w bazie danych:

     }

     public function EditArticle(string $articleId, string $userId)
     {
        //wyszukiwanie artykułu w bazie danych 

        //sprawdzenie czy artykuł został dodany przez zalogowanego użytkownika

        //edycja danych w bazie do danego artykułu

        //zapisywanie nowych danych w bazie
     }

     public function DropArticle(string $articleId, string $userId)
     {
        //wyszukiwanie artykułu w bazie danych 

        //sprawdzenie czy artykuł został dodany przez zalogowanego użytkownika

        //usuwanie artykułu z bazy
     }
}
