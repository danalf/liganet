<?php

namespace AppBundle\Security;

use AppBundle\Entity\SpielRunde;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class SpielRundeVoter extends Voter
{

    const VIEW = 'view';
    const EDIT = 'edit';

    private $decisionManager;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, array(self::VIEW, self::EDIT))) {
            return false;
        }

        if (!$subject instanceof SpielRunde) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        if ($this->decisionManager->decide($token, array('ROLE_ADMIN'))) {
            return true;
        }

        /** @var SpielRunde $spielrunde */
        $spielrunde = $subject;

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($spielrunde, $user);
            case self::EDIT:
                return $this->canEdit($spielrunde, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canView(SpielRunde $spielrunde, User $user)
    {
        return true;
    }

    private function canEdit(SpielRunde $spielrunde, User $user)
    {
        $spieler = $user->getSpieler();
        $ligaSaison = $spielrunde->getSpieltag()->getLigasaison();

        foreach ($ligaSaison->getStaffelleiter() as $leiter) {
            if ($spieler == $leiter) {
                return true;
            }
        }

        foreach ($ligaSaison->getLiga()->getRegion()->getLeiter() as $leiter) {
            if ($spieler == $leiter) {
                return true;
            }
        }

        return false;
    }

}
