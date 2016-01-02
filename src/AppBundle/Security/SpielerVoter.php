<?php

namespace AppBundle\Security;

use AppBundle\Entity\Spieler;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class SpielerVoter extends Voter
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

        if (!$subject instanceof Spieler) {
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

        if ($this->decisionManager->decide($token, array('ROLE_REGION_MANAGEMENT'))) {
            return true;
        }

        /** @var Spieler $spieler */
        $spieler = $subject;

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($spieler, $user);
            case self::EDIT:
                return $this->canEdit($spieler, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canView(Spieler $spieler, User $user)
    {
        return true;
    }

    private function canEdit(Spieler $spieler, User $user)
    {
        $userSpieler = $user->getSpieler();
        $verein = $spieler->getVerein();
        foreach ($verein->getLeiter() as $leiter) {
            if ($userSpieler == $leiter) {
                return true;
            }
        }
        foreach ($verein->getRegion()->getLeiter() as $leiter) {
            if ($userSpieler == $leiter) {
                return true;
            }
        }

        return false;
    }

}
