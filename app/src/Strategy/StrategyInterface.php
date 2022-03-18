<?php
namespace App\Strategy;

use App\Model\MyUserInterface;

interface StrategyInterface
{
    public function UserActivate(MyUserInterface $user);
}