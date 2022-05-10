<?php

namespace App\User\Infrastructure\Web\Controller;

use App\User\Domain\Entity\Exercise;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\User\Domain\Repository\ExerciseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ExerciseController extends AbstractController
{
    #[Route('/cwiczenia', name: 'exercises')]
    public function index(ExerciseRepository $exerciseRepository): Response
    {
        $exercises = $exerciseRepository->findAll();
        return $this->render('Exercise/index.html.twig', [
            'exercises' => $exercises,
        ]);
    }

    #[Route('/cwiczenia/dodaj', name: 'new-exercise')]
    public function createExerciseAction(ExerciseRepository $exerciseRepository, Request $request, EntityManagerInterface $em)
    {
        $loggedUser = $this->getUser();
        if($this->isGranted('ROLE_USER') && $loggedUser->isCoach)
        {
            $exerciseEntity = new Exercise();
            $form = $this->createForm(ExerciseType::class, $exerciseEntity);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid())
            {
                $directory = '/var/www/symfony_docker/public/exercises/files';
                $file = $form['ImagePath']->getData();
                $file2 = $form['VideoPath']->getData();
                $somefilename = $file->getClientOriginalName();
                $anotherfilename = $file->getClientOriginalName();
                $file->move($directory, $somefilename);
                $file2->move($directory, $anotherfilename);

                $exerciseEntity->setImagePath('/exercises/files/' . $somefilename);
                $exerciseEntity->setVideoPath('/exercises/files/' . $anotherfilename);

                $exerciseEntity->setAuthor($loggedUser);
                //$exerciseEntity->setCreatedAt(new DateTime());
                $em->persist($exerciseEntity);
                $em->flush();
            }           
            return $this->render('Exercise/dodawanie.html.twig', 
             ['exerciseForm' => $form->createView()]);


        }
    }
}
