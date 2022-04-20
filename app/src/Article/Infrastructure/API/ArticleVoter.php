<?php

namespace App\Article\Infrastructure\API;

use App\User\Domain\Entity\User;
use App\User\Domain\Entity\Article;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;


class ArticleVoter extends Voter
{
    // these strings are just invented: you can use anything
    const VIEW = 'view';
    const ADD = 'add';
    const EDIT = 'edit';
    const DROP = 'drop';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::VIEW, self::ADD, self::EDIT, self::DROP])) {
            return false;
        }

        // only vote on `Article` objects
        if (!$subject instanceof Article) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        // ROLE_SUPER_ADMIN can do anything! The power! -- W tym wypadku mowa o Moderatorze 
        // Tylko Moderator ma rolę ROLE_SUPER_ADMIN
        if ($this->security->isGranted('ROLE_SUPER_ADMIN')) {
            return true;
        }

        // you know $subject is a Post object, thanks to `supports()`
        /** @var Article $article */
        $article = $subject;

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($article, $user);
            case self::ADD:
                return $this->canAdd($article, $user);
            case self::EDIT:
                return $this->canEdit($article, $user);
            case self::DROP:
                return $this->canDrop($article, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canView(Article $article, User $user): bool
    {
        // if they can edit, add or drop, they can view
        if ($this->canEdit($article, $user) && $this->canAdd($article, $user) && $this->canDrop($article, $user)) {
            return true;
        }

        // // the Article object could have, for example, a method `isPrivate()`
        // return !$article->isPrivate();
    }

    private function canEdit(Article $article, User $user): bool
    {
        // this assumes that the Article object has a `getAuthor()` method
        return $user === $article->getAuthor();
    }

    private function canAdd(Article $article, User $user): bool
    {
        // this assumes that the Article object has a `getAuthor()` method
        return $user === $article->getAuthor();
    }

    private function canDrop(Article $article, User $user): bool
    {
        // this assumes that the Article object has a `getAuthor()` method
        return $user === $article->getAuthor();
    }
}