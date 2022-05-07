<?php

namespace App\User\Application;

use App\User\Domain\Entity\User;

interface SpecificationInterface
{
    public function isSatisfiedBy(User $user): bool;
}