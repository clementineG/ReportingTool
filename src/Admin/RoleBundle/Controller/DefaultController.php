<?php

namespace Admin\RoleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Admin\RoleBundle\Entity\Role;
use Admin\RoleBundle\Form\RoleType;

class DefaultController extends Controller
{
    const bundleName = 'AdminRoleBundle';
    const entityName = 'Role';
    const indexRoute = 'admin_role';
    const repository = 'Admin\RoleBundle\Entity\Role';
    
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getManager()
                ->getRepository('AdminRoleBundle:Role');

        $rolesList = $repository->findAll();

        return $this
                ->render('AdminRoleBundle:Default:index.html.twig',
                        array('rolesList' => $rolesList));
    }

    public function addAction()
    {
        return $this->formAction(new Role(), 'Ajouter un utilisateur');
    }

    public function modifyAction($id)
    {
        // récupération des données via l'id de l'utilisateur sélectionné
        $role = $this->getDoctrine()
                ->getRepository(self::repository)->find($id);
    
        return $this->formAction($role, 'Modifier un utilisateur');
    }

    private function formAction($role, $description)
    {
        $form = $this->createForm(new RoleType(), $role);

        // récupération de la requête
        $request = $this->get('request');

        // vérification du type de la requete
        if ($request->getMethod() == 'POST') {
            // execution de la requete
            $form->bind($request);

            // vérification de la validité des données saisies
            if ($form->isValid()) {
                // enregistrement de l'objet $role dans la BD
                $em = $this->getDoctrine()->getManager();
                $em->persist($role);
                $em->flush();

                // redirection vers la page de visualisation de la liste des utilisateurs
                return $this->redirect($this->generateUrl(self::indexRoute));
            }
        }

        // - si requete de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
        // - si requete de type POST, mais le formulaire n'est pas valide, donc on l'affiche de nouveau
        return $this
                ->render('AdminRoleBundle:Default:form.html.twig',
                        array('form' => $form->createView(),
                              'description'=> $description,
                              'index_route' => self::indexRoute));
    }
    
}