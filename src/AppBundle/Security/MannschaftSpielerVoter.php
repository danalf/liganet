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
    const CONFIRM = 'confirm';

    private $decisionManager;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, array(self::VIEW, self::EDIT, self::CONFIRM))) {
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
            case self::CONFIRM:
                return $this->_canConfirm($mannschaftSpieler, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canView(MannschaftSpieler $mannschaftSpieler, User $user)
    {
        return true;
    }

    /**
     * Check if entity is allowed to edit for user
     * 
     * @param MannschaftSpieler $mannschaftSpieler the entity to edit
     * @param User              $user              The user who wants to edit
     * 
     * @return boolean Is editing allowed?
     */
    private function canEdit(MannschaftSpieler $mannschaftSpieler, User $user)
    {
        $spieler = $user->getSpieler();
        $mannschaft = $mannschaftSpieler->getMannschaft();
        $verein = $mannschaft->getVerein();
        // Vereinsleiter and Staffelleiter only allowed to change if bestaetigt is false
        if ($mannschaftSpieler->getBestaetigt() == false ) {
            if ($verein->getLeiter()->contains($spieler)) {
                return true;
            }
            if ($mannschaft->getLigasaison()->getStaffelleiter()->contains($spieler)) {
                return true;
            }
        }
        if ($verein->getRegion()->getLeiter()->contains($spieler)) {
            return true;
        }
        if ($mannschaft->getLigasaison()->getLiga()->getRegion()->getLeiter()->contains($spieler)) {
            return true;
        }

        return false;
    }

    /**
     * Check if entity is allowed to confirm for user
     * 
     * @param MannschaftSpieler $mannschaftSpieler the entity to edit
     * @param User              $user              The user who wants to edit
     * 
     * @return boolean Is confirming allowed?
     */
    private function _canConfirm(MannschaftSpieler $mannschaftSpieler, User $user)
    {
        $spieler = $user->getSpieler();
        $mannschaft = $mannschaftSpieler->getMannschaft();
        $verein = $mannschaft->getVerein();
        // Vereinsleiter and Staffelleiter only allowed to change if bestaetigt is false
        if ($mannschaftSpieler->getBestaetigt() == false ) {
            if ($mannschaft->getLigasaison()->getStaffelleiter()->contains($spieler)) {
                return true;
            }
        }
        if ($verein->getRegion()->getLeiter()->contains($spieler)) {
            return true;
        }
        if ($mannschaft->getLigasaison()->getLiga()->getRegion()->getLeiter()->contains($spieler)) {
            return true;
        }

        return false;
    }

}
