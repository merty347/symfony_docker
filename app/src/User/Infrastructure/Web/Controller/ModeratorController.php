<?php

namespace App\User\Infrastructure\Web\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\User\Domain\Entity\User;
use App\Article\Domain\Entity\Article;
use App\Form\EntryArticleForm;


/**
 * @Route("/moderator")
 */
class ModeratorController extends AbstractController
{
    
}