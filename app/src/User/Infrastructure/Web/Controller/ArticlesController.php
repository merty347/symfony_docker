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
    public function index(ArticleRepository $articleRepository): Response
    {        
        $articles = $articleRepository->findAll();
        return $this->render('User/Web/Article/Twig/index.html.twig',
        ['articles' => $articles]);
    }

   #[Route('/artykul/dodaj', name: 'new-article')]
   public function createArticleAction(EntityManagerInterface $em, Request $request)
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
            return $this->render('User/Web/Article/Twig/dodawanie.html.twig', 
             ['articleForm' => $form->createView()]);   
            //return $this->render('User/Web/Article/Twig/index.html.twig', ['articles' => $articles]);
            
        }
        else
        {
            return $this->render('User/Web/Login/Twig/login.html.twig');

        }
               
   }

   #[Route('/artykul/{id}', name: 'eachArticle')]
   public function showArticleAction(int $id, ArticleRepository $articleRepository)
   {
        //$em = $doctrine->getManager();
        //pobieranie wszystkich artykułów
        //$articles = $articleRepository->findAll();
        $eachArticle = $articleRepository->findOneBy(['id' => $id]);
        $eachArticle->getAuthor();
        if($eachArticle)
        {
            return $this->render('User/Web/Article/Twig/eacharticle.html.twig', array('article' => $eachArticle));
        }
        else
        {
            throw $this->createNotFoundException(
                'No article found for id '.$id
            );
        }

   }

   #[Route('/artykul/{id}/edit', name: 'editArticle')]
   public function editArticleAction(int $id, ArticleRepository $articleRepository, EntityManagerInterface $em, Request $request)
   {
        $article = $articleRepository->findOneBy(['id' => $id]);

        if($this->isGranted('ROLE_USER'))
        {
            //sprawdzanie czy usera artykuł 
            if ($article->getAuthor() !== $this->getUser()) 
            {
                throw $this->createAccessDeniedException();
            }
            else
            {                     
                if (!$article) 
                {
                    throw $this->createNotFoundException(
                        'No article found for id '.$id
                    );
                }
                else
                {
                    $form = $this->createForm(ArticleType::class, $article);
                    $form->handleRequest($request);
                    if ($form->isSubmitted() && $form->isValid()) 
                    {
                        /** @var Article $article */
                        $article = $form->getData();
                        $em->persist($article);
                        $em->flush();
                    }
                }
                
                return $this->render('User/Web/Article/Twig/editarticle.html.twig', 
                ['articleForm' => $form->createView()]);   
            }
        }
        else
        {
            return $this->render('User/Web/Login/Twig/login.html.twig');

        }
   }
     

}
