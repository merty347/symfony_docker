<?php 

namespace App\User\Infrastructure\Web\Controller;

use DateTime;
use App\User\Domain\Entity\User;
use App\User\Domain\Entity\Article;
use App\User\Domain\Repository\ArticleRepository;
use App\Article\Infrastructure\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;



class ArticlesController extends AbstractController 
{
    private $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function index(): Response
    {
        
        return $this->render('User/Web/Article/Twig/index.html.twig');
    }

   #[Route('/artykul/dodaj', name: 'new-article')]
   public function CreateArticle(EntityManagerInterface $em, Request $request)
   {  
        //czy zalogowany user
        if($this->isGranted('ROLE_USER'))
        {
            $author = $this->getUser();
            $articleEntity =  new Article(); 
            $form = $this->createForm(ArticleType::class,$articleEntity);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid())
            {
                $articleEntity->setAuthor($author);
                $articleEntity->setCreatedAt(new DateTime());
                $em->persist($articleEntity);
                $em->flush();
            }           
            

            // return $this->render('User/Web/Article/Twig/dodawanie.html.twig', 
            // ['articleForm' => $form->createView()]);   
            return $this->render('User/Web/Article/Twig/index.html.twig');
            
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
