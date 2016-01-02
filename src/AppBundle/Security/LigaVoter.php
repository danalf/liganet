<?php

namespace AppBundle\Security;

use AppBundle\Entity\Liga;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class LigaVoter extends Voter
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

        if (!$subject instanceof Liga) {
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
        
        if ($this->decisionManager->decide($token, array('ROLE_REGION_MANAGEMENT'))) {
            return true;
        }

        /** @var Liga $liga */
        $liga = $subject;

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($liga, $user);
            case self::EDIT:
                return $this->canEdit($liga, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canView(Liga $liga, User $user)
    {
        return true;
    }

    private function canEdit(Liga $liga, User $user)
    {
        $spieler = $user->getSpieler();

        foreach ($liga->getRegion()->getLeiter() as $leiter) {
            if ($spieler == $leiter) {
                return true;
            }
        }

        return false;
    }

}
