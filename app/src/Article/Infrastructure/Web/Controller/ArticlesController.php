<?php

namespace App\Article\Infrastructure\Web\Controller;

use DateTime;
use App\User\Domain\Entity\User;
use App\Article\Domain\Entity\Article;
use App\Article\Domain\Repository\ArticleRepository;
use App\Article\Infrastructure\Form\ArticleType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/", name="homepage")
 */
class ArticlesController extends AbstractController 
{
    private ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        //właściwości przekazuje zmienną lokalną
        $this->articleRepository = $articleRepository;
    }

   #[Route('/artykul/dodaj', name: 'new-article')]
   public function CreateArticle()
   {        
        //czy zalogowany user
        if($this->denyAccessUnlessGranted('add'))
        {
            $articleEntity = $this->articleRepository->CreateArticle();
            $form = $this->createForm(ArticleType::class);

                return $this->render('User/Web/Article/Twig/dodawanie.html.twig', ['articleForm' => $form->createView()]);
        
        }
        else
        {
            return $this->render('User/Web/Login/Twig/login.html.twig');

        }
        

       
   }

   //TODO edytowanie artykułów ------ zdjęcia w artykułach będą tablicą, bo to może być galeria (I Guesssssss)
   public function EditArticle(Article $article, User $user, string $content, string $title)
   {
        //sprawdzanie czy user zalogowany i czy jego artykuł 
        if ($article->getAuthor() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }
        //wyszukiwanie artykułu w bazie 

        //zmienianie danych w artykule
        //updatowanie bazy
   }
     

}
