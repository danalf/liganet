<?php

namespace Liganet\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HelloController extends Controller {

    public function indexAction($name) {
        
        $this->get('session')->getFlashBag()->add('notice', 'Your changes were saved!');
        return $this->render('LiganetCoreBundle:Hello:index.html.twig', array('name' => $name));
    }
    
    public function showUsersAction(){
        $userManager = $this->container->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('username' => 'Andreas'));
        $user->addRole('ROLE_REGION_MANAGEMENT');
        $userManager->updateUser($user);
        $users = $this->getDoctrine()->getRepository('UserBundle:User')->findAll();
        return $this->render('LiganetCoreBundle:Hello:showUsers.html.twig', array('users' => $users));
        return null;
    }

}