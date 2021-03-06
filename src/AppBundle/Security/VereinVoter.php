<?php
namespace AppBundle\Security;

use AppBundle\Entity\Verein;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class VereinVoter extends Voter
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
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, array(self::VIEW, self::EDIT))) {
            return false;
        }

        // only vote on Post objects inside this voter
        if (!$subject instanceof Verein) {
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

        /** @var Verein $verein */
        $verein = $subject;

        switch($attribute) {
            case self::VIEW:
                return $this->canView($verein, $user);
            case self::EDIT:
                return $this->canEdit($verein, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canView(Verein $verein, User $user)
    {
        return true;
    }

    private function canEdit(Verein $verein, User $user)
    {
        $spieler=$user->getSpieler();
        foreach ($verein->getLeiter() as $leiter) {
                if ($spieler == $leiter){
                    return true;
                } 
            }
            foreach ($verein->getRegion()->getLeiter() as $leiter) {
                if ($spieler == $leiter){
                    return true;
                }
            }
        return false;
    }
}