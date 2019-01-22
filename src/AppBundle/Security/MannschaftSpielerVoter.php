<?php

namespace AppBundle\Security;

use AppBundle\Entity\MannschaftSpieler;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class MannschaftSpielerVoter extends Voter
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

        if (!$subject instanceof MannschaftSpieler) {
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

        /** @var MannschaftSpieler $mannschaftSpieler */
        $mannschaftSpieler = $subject;

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($mannschaftSpieler, $user);
            case self::EDIT:
                return $this->canEdit($mannschaftSpieler, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canView(MannschaftSpieler $mannschaftSpieler, User $user)
    {
        return true;
    }

    private function canEdit(MannschaftSpieler $mannschaftSpieler, User $user)
    {
        $spieler=$user->getSpieler();
        $mannschaft = $mannschaftSpieler->getMannschaft();
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
