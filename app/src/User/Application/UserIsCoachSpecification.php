<?php

namespace App\User\Application;

use App\User\Domain\Entity\User;

class UserIsCoachSpecification implements SpecificationInterface
{
    public function isSatisfiedBy(User $user): bool
    {
        return $user->getIsCoach();
    }
}