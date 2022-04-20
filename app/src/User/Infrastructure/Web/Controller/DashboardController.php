<?php

namespace App\User\Infrastructure\Web\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\User\Domain\Entity\User;

class DashboardController extends AbstractController 
{    
    #[Route('/myacount', name: 'dashboard')]
    public function index(): Response
    {
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }

    //funkcja do tworzenia forma dzięki któremu ustala się czy jest coach czy editor
    public function setType(User $user)
    {        
        

    }

    //funkcja do edytowania konta
    public function EditAccount(User $user)
    {
        //sprawdzanie czy dany user jest zalogowany

        //edycja danych w bazie 

        //zapisywanie
    }

    //funkcja do wyświetlania treningów
    

    //funkcja do wyświetlania artykułów
    
}
