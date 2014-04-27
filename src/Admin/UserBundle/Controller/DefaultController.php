<?php

namespace Admin\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Admin\UserBundle\Entity\User;
use Admin\UserBundle\Form\UserType;

class DefaultController extends Controller
{
    const bundleName = 'AdminUserBundle';
    const entityName = 'User';
    const indexRoute = 'admin_user';
    const repository = 'Admin\UserBundle\Entity\User';

    public function indexAction()
    {
        $repository = $this->getDoctrine()->getManager()
                ->getRepository('AdminUserBundle:User');

        $usersList = $repository->findAll();

        return $this
                ->render('AdminUserBundle:Default:index.html.twig',
                        array('usersList' => $usersList));
    }

    public function addAction()
    {
        return $this->formAction(new User(), 'Ajouter un utilisateur');
    }

    public function modifyAction($id)
    {
        // récupération des données via l'id de l'utilisateur sélectionné
        $user = $this->getDoctrine()
                ->getRepository(self::repository)->find($id);
    
        return $this->formAction($user, 'Modifier un utilisateur');
    }

    private function formAction($user, $description)
    {
        $form = $this->createForm(new UserType(), $user);

        // récupération de la requête
        $request = $this->get('request');

        // vérification du type de la requete
        if ($request->getMethod() == 'POST') {
            // execution de la requete
            $form->bind($request);

            // vérification de la validité des données saisies
            if ($form->isValid()) {
                // enregistrement de l'objet $user dans la BD
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                // redirection vers la page de visualisation de la liste des utilisateurs
                return $this->redirect($this->generateUrl(self::indexRoute));
            }
        }

        // - si requete de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
        // - si requete de type POST, mais le formulaire n'est pas valide, donc on l'affiche de nouveau
        return $this
                ->render('AdminUserBundle:Default:form.html.twig',
                        array('form' => $form->createView(),
                              'description'=> $description,
                              'index_route' => self::indexRoute));
    }
    
    public function changeStatusAction($id)
    {
        // récupération des données via l'id de l'utilisateur sélectionné
        $user = $this->getDoctrine()
                ->getRepository('Admin\UserBundle\Entity\User')->find($id);

        // inversion de la valeur de l'attribut "enabled" de l'utilisateur
        $user->setEnabled(!$user->getEnabled());

        // enregistrement de notre objet $user dans la base de données
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        // redirection vers la page de visualisation de la liste des utilisateurs
        return $this->redirect($this->generateUrl(self::indexRoute));
    }

}
