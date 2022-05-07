<?php 

namespace App\User\Infrastructure\Web\Controller;

use DateTime;
use App\User\Domain\Entity\User;
use App\User\Domain\Entity\Article;
use App\User\Domain\Repository\ArticleRepository;
use App\Article\Infrastructure\Form\ArticleType;
use App\User\Domain\Repository\StatisticsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
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
    public function index(ArticleRepository $articleRepository, StatisticsRepository $statisticsRepository): Response
    {        
        $articles = $articleRepository->findAll();
        $statistics = $statisticsRepository->findAll();
        // $pagerfanta = new Pagerfanta(new QueryAdapter($articles));
        // $pagerfanta->setMaxPerPage(5);

        $images = array();
        foreach ($articles as $key => $entity){
            $images[$key] = $entity->getmainImagePath();
        }

        return $this->render('User/Web/Article/Twig/index.html.twig',
        ['articles' => $articles, 'images' => $images, 'statistics' => $statistics
        ]);
    }

    #[Route('/twitter-newsy', name: 'tweets')]
    public function twitterIndex(StatisticsRepository $statisticsRepository)
    {
        $statistics = $statisticsRepository->findAll();
        return $this->render('User/Web/Tweets/tweets.html.twig', ['statistics' => $statistics]);
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
                $directory = '/var/www/symfony_docker/public/files';
                $file = $form['mainImagePath']->getData();
                $somefilename = $file->getClientOriginalName();
                $file->move($directory, $somefilename);

                $articleEntity->setMainImagePath('/files/' . $somefilename);

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
   public function showArticleAction(int $id, ArticleRepository $articleRepository, StatisticsRepository $statisticsRepository)
   {
        //$em = $doctrine->getManager();
        //pobieranie wszystkich artykułów
        //$articles = $articleRepository->findAll();
        $statistics = $statisticsRepository->findAll();

        $eachArticle = $articleRepository->findOneBy(['id' => $id]);
        $eachArticle->getAuthor();
        if($eachArticle)
        {
            return $this->render('User/Web/Article/Twig/eacharticle.html.twig', array('article' => $eachArticle, 
            'statistics' => $statistics));
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
