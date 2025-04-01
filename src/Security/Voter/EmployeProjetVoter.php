<?php

namespace App\Security\Voter;

use App\Entity\Employe;
use App\Entity\Projet;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class EmployeProjetVoter extends Voter
{
    public const ACCEDER = 'PROJET_ACCES';
    /**
     * @inheritDoc
     */
    protected function supports(string $attribute, mixed $subject): bool
    {
        return $attribute === self::ACCEDER && $subject instanceof Projet;
    }

    /**
     * @inheritDoc
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        // TODO: Implement voteOnAttribute() method.
        /** @var Employe $user */
        $user = $token->getUser();
        if(!$user instanceof Employe){
            return false;
        }

        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            return true;
        }

        return $subject->getEmployes()->contains($user);
    }
}