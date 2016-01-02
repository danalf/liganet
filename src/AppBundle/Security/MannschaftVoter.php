<?php

namespace AppBundle\Security;

use AppBundle\Entity\Mannschaft;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class MannschaftVoter extends Voter
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

        if (!$subject instanceof Mannschaft) {
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

        /** @var Mannschaft $mannschaft */
        $mannschaft = $subject;

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($mannschaft, $user);
            case self::EDIT:
                return $this->canEdit($mannschaft, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canView(Mannschaft $mannschaft, User $user)
    {
        return true;
    }

    private function canEdit(Mannschaft $mannschaft, User $user)
    {
        $spieler=$user->getSpieler();
        $verein = $mannschaft->getVerein();
        foreach ($verein->getLeiter() as $leiter) {
            if ($spieler == $leiter) {
                return true;
            }
        }
        foreach ($verein->getRegion()->getLeiter() as $leiter) {
            if ($spieler == $leiter) {
                return true;
            }
        }

        $captain = $mannschaft->getCaptain();
        if (isset($captain)) {
            if ($mannschaft->getCaptain() == $spieler){
                return true;
            }
        }
        foreach ($mannschaft->getVerein()->getLeiter() as $leiter) {
            if ($spieler == $leiter){
                return true;
            }
        }
        foreach ($mannschaft->getLigasaison()->getStaffelleiter() as $leiter) {
            if ($spieler == $leiter){
                return true;
            }
        }
        foreach ($mannschaft->getLigasaison()->getLiga()->getRegion()->getLeiter() as $leiter) {
            if ($spieler == $leiter){
                return true;
            }
        }

        return false;
    }

}
