<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Liganet\CoreBundle\Form\Type\AdminType;

/**
 * Admin controller.
 *
 * @Route("/admin")
 */
class AdminController extends Controller
{

    /**
     * Lists all User entities.
     *
     * @Route("/", name="admin_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $message = \Swift_Message::newInstance()
                ->setSubject('Hello Email')
                ->setFrom('admin@liga-net.de')
                ->setTo('alfredo@danalf.de')
                ->setBody(
                $this->renderView(
                        'admin/email.txt.twig', array('user' => $this->getUser(), 'confirmationUrl' => 'test')
                )
        );
        $this->get('mailer')->send($message);
        $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();


        return $this->render('admin/index.html.twig', array('users' => $users));
    }

    public function editAction($id)
    {
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
                $roles = $roles['roleList'];
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

    /**
     * @Route("/", name="admin_clear_cache")
     */
    public function clearCacheAction()
    {
        if (!$this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $this->get('session')->getFlashBag()->add('error', 'Nur für den Admin');
            return $this->redirect($this->generateUrl('_home'));
        }
        $erg = $this->rec_rmdir('../app/cache/dev');
        $erg = $this->rec_rmdir('../app/cache/prod');
        //phpinfo();
        return $this->render('admin:clearCache.html.twig', array('ergebnis' => $erg));
    }

    // rec_rmdir - loesche ein Verzeichnis rekursiv
// Rueckgabewerte:
//   0  - alles ok
//   -1 - kein Verzeichnis
//   -2 - Fehler beim Loeschen
//   -3 - Ein Eintrag eines Verzeichnisses war keine Datei und kein Verzeichnis und
//        kein Link
    private function rec_rmdir($path)
    {
        // schau' nach, ob das ueberhaupt ein Verzeichnis ist
        if (!is_dir($path)) {
            return -1;
        }
        // oeffne das Verzeichnis
        $dir = @opendir($path);

        // Fehler?
        if (!$dir) {
            return -2;
        }

        // gehe durch das Verzeichnis
        while (($entry = @readdir($dir)) !== false) {
            // wenn der Eintrag das aktuelle Verzeichnis oder das Elternverzeichnis
            // ist, ignoriere es
            if ($entry == '.' || $entry == '..')
                continue;
            // wenn der Eintrag ein Verzeichnis ist, dann 
            if (is_dir($path . '/' . $entry)) {
                // rufe mich selbst auf
                $res = $this->rec_rmdir($path . '/' . $entry);
                // wenn ein Fehler aufgetreten ist
                if ($res == -1) { // dies duerfte gar nicht passieren
                    @closedir($dir); // Verzeichnis schliessen
                    return -2; // normalen Fehler melden
                } else if ($res == -2) { // Fehler?
                    @closedir($dir); // Verzeichnis schliessen
                    return -2; // Fehler weitergeben
                } else if ($res == -3) { // nicht unterstuetzer Dateityp?
                    @closedir($dir); // Verzeichnis schliessen
                    return -3; // Fehler weitergeben
                } else if ($res != 0) { // das duerfe auch nicht passieren...
                    @closedir($dir); // Verzeichnis schliessen
                    return -2; // Fehler zurueck
                }
            } else if (is_file($path . '/' . $entry) || is_link($path . '/' . $entry)) {
                // ansonsten loesche diese Datei / diesen Link
                $res = @unlink($path . '/' . $entry);
                // Fehler?
                if (!$res) {
                    @closedir($dir); // Verzeichnis schliessen
                    return -2; // melde ihn
                }
            } else {
                // ein nicht unterstuetzer Dateityp
                @closedir($dir); // Verzeichnis schliessen
                return -3; // tut mir schrecklich leid...
            }
        }

        // schliesse nun das Verzeichnis
        @closedir($dir);

        // versuche nun, das Verzeichnis zu loeschen
        $res = @rmdir($path);

        // gab's einen Fehler?
        if (!$res) {
            return -2; // melde ihn
        }

        // alles ok
        return 0;
    }

}
