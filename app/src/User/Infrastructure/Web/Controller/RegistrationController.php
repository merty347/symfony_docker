<?php

namespace App\User\Infrastructure\Web\Controller;

use App\User\Domain\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use App\Entity\Coach;
use Doctrine\DBAL\Types\TextType;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, LoginFormAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
            // ->add('Email', 'User', array(
            //     'attr' => array('placeholder' => 'Your Email')));
        $form->handleRequest($request);
        
        //if ($form->coach->isset) to wtedy create formCoach jak niżej 

        // //NOWE -- chyba trzeba przerzucić do innej funkcji, ale jeszcze idk 
        // $coach = new Coach();
        // $formCoach = $this->createFormBuilder($user)
        //     ->add('coach', CheckboxType::class)
        //     ->getForm();
        // if($formCoach->isSubmitted())
        // {
        //     //użytkownik chce być ten trenerem
        //     $formCoachData = $this->createFormBuilder($coach)
        //     ->add('discipline', TextType::class)
        //     ->add('FirstName', TextType::class)
        //     ->add('LastName', TextType::class)
        //     ->add('Team', TextType::class)
        //     ->add('LicenseNumber', TextType::class)
        //     ->getForm();
        // }
        // //END NOWE

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('User/Web/Register/Twig/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
