<?php

namespace Admin\ComponentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Admin\ComponentBundle\Entity\Component;
use Admin\ComponentBundle\Form\ComponentType;

class DefaultController extends Controller
{
    const bundleName = 'AdminComponentBundle';
    const entityName = 'Component';
    const indexRoute = 'admin_component';
    const repository = 'Admin\ComponentBundle\Entity\Component';
    
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getManager()
                ->getRepository('AdminComponentBundle:Component');

        $componentsList = $repository->findAll();

        return $this
                ->render('AdminComponentBundle:Default:index.html.twig',
                        array('componentsList' => $componentsList));
    }

    public function addAction()
    {
        return $this->formAction(new Component(), 'Ajouter un composant');
    }
    
    public function modifyAction($id)
    {
        // récupération des données via l'id de l'utilisateur sélectionné
        $component = $this->getDoctrine()
        ->getRepository(self::repository)->find($id);
    
        return $this->formAction($component, 'Modifier un composant');
    }
        
    private function formAction($component, $description)
    {
        $form = $this->createForm(new ComponentType(), $component);
    
        // récupération de la requête
        $request = $this->get('request');
    
        // vérification du type de la requete
        if ($request->getMethod() == 'POST') {
            // execution de la requete
            $form->bind($request);
    
            // vérification de la validité des données saisies
            if ($form->isValid()) {
                // enregistrement de l'objet $component dans la BD
                $em = $this->getDoctrine()->getManager();
                $em->persist($component);
                $em->flush();
    
                // redirection vers la page de visualisation de la liste des utilisateurs
                return $this->redirect($this->generateUrl(self::indexRoute));
            }
        }
    
        // - si requete de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
        // - si requete de type POST, mais le formulaire n'est pas valide, donc on l'affiche de nouveau
        return $this
        ->render('AdminComponentBundle:Default:form.html.twig',
                array('form' => $form->createView(),
                        'description'=> $description,
                        'index_route' => self::indexRoute));
    }
    
}
