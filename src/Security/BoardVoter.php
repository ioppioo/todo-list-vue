<?php

namespace App\Security;

use App\Entity\Board;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class BoardVoter extends Voter
{

    protected function supports(string $attribute, mixed $subject): bool
    {

        return $subject instanceof Board;

    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {

        $user = $token->getUser();

        if (!$user instanceof User) {

            return false;
        }

        /** @var Board $board */
        $board = $subject;

        return $board->getUser() === $user;

    }
}