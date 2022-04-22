<?php

namespace App\User\Infrastructure\Web\Controller;

use App\User\Domain\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\User\Domain\Repository\UserRepository;
use App\User\Infrastructure\Form\UserFormType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\User\Domain\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DashboardController extends AbstractController 
{    
    #[Route('/myaccount', name: 'dashboard')]
    public function index(ArticleRepository $articleRepository): Response
    {
        //$this->getAllArticles($articleRepository, $request);
        $loggedUser = $this->getUser();
        // $author = $loggedUser->getUserIdentifier();
        $articlesCreatedbyUser = $articleRepository->findBy(array('Author' => $loggedUser->getUserIdentifier()));
        return $this->render('UserDashboard/index.html.twig', [
            'articlesByUser' => $articlesCreatedbyUser,
        ]);
    }
    
    #[Route('/userpage/{username}/{id}', name: 'userpage')]
    public function showUserPageAction(int $id, UserRepository $userRepository, ArticleRepository $articleRepository)
    {
        $user = $userRepository->findOneBy(['id' => $id]);
        $articlesCreatedbyUser = $articleRepository->findBy(array('Author' => $user->getUserIdentifier()));
        return $this->render('UserDashboard/userpage.html.twig', [
            'user' => $user, 
            'articlesByUser' => $articlesCreatedbyUser,
        ]);

    }

    //funkcja do edytowania konta
    #[Route('/myaccount/editprofile', name: 'editprofile')]
    public function editProfileAction(UserRepository $userRepository, EntityManagerInterface $em, Request $request)
    {
        //sprawdzanie czy dany user jest zalogowany
        if($this->isGranted('ROLE_USER'))
        {
            $user = $this->getUser();
            $form = $this->createForm(UserFormType::class, $user);
                    $form->handleRequest($request);
                    if ($form->isSubmitted() && $form->isValid()) 
                    {
                        /** @var User $user */
                        $user = $form->getData();
                        $em->persist($user);
                        $em->flush();
                    }
                
                return $this->render('UserDashboard/editprofile.html.twig', 
                ['userprofileForm' => $form->createView()]); 
        }
    }
    
}
