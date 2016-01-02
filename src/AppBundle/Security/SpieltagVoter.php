<?php

namespace AppBundle\Security;

use AppBundle\Entity\Spieltag;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class SpieltagVoter extends Voter
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

        if (!$subject instanceof Spieltag) {
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

        /** @var Spieltag $spieltag */
        $spieltag = $subject;

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($spieltag, $user);
            case self::EDIT:
                return $this->canEdit($spieltag, $user, $token);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canView(Spieltag $spieltag, User $user)
    {
        return true;
    }

    private function canEdit(Spieltag $spieltag, User $user)
    {

        $spieler = $user->getSpieler();

        foreach ($spieltag->getLigasaison()->getStaffelleiter() as $leiter) {
            if ($spieler == $leiter) {
                return true;
            }
        }

        foreach ($spieltag->getLigasaison()->getLiga()->getRegion()->getLeiter() as $leiter) {
            if ($spieler == $leiter) {
                return true;
            }
        }

        return false;
    }

}
