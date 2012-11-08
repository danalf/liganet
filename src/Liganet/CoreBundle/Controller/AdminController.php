<?php

namespace Liganet\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Liganet\CoreBundle\Form\Type\AdminType;

class AdminController extends Controller {

    public function indexAction() {
        //$userList = $this->container->get('fos_user.user_manager');
        //$user = $userList->findUserBy(array('username' => 'alfredo'));
        //$user->addRole('ROLE_ADMIN');
        //$userList->updateUser($user); // persists the object
        //$this->get('session')->getFlashBag()->add('notice', 'Your changes were saved!');
        $users = $this->getDoctrine()->getRepository('UserBundle:User')->findAll();
        return $this->render('LiganetCoreBundle:Admin:index.html.twig', array('users' => $users));
    }

    public function editAction($id) {
        $user = $this->getDoctrine()->getRepository('UserBundle:User')
                ->find($id);
        if ($user == false) {
            $this->get('session')->getFlashBag()->add('error', 'Datensatz nicht vorhanden!');
            return $this->redirect($this->generateUrl('admin_index'));
        }
        $form = $this->createForm(new AdminType(), $user);

        $request = $this->getRequest();
        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {

                $roles = $this->get('request')->request->get('admin');
                $roles=$roles['roleList'];
                foreach ($roles as $key => $value) {
                    var_dump($value);
                    $userList = $this->container->get('fos_user.user_manager');
                    $user->addRole($value);
                    $userList->updateUser($user);
                }
//                $em = $this->getDoctrine()->getManager();
//
//                $em->persist($user);
//                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'Die Änderungen wurden gespeichert!');


                //return $this->redirect($this->generateUrl('admin_index'));
            }
        }
        return $this->render('LiganetCoreBundle:Admin:edit.html.twig', array(
                    'form' => $form->createView(),
                    'user' => $user,
                ));
    }

}