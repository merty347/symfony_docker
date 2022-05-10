<?php

namespace App\User\Infrastructure\Web\Controller;

use App\User\Domain\Entity\Coach;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CoachCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Coach::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
