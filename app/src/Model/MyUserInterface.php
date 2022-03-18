<?php
    namespace App\Model;
    use App\User\Domain\Entity\User;

    interface MyUserInterface
    {
        public function setType(User $user);
    }