<?php

namespace ProjectManager\ParameterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use ProjectManager\ParameterBundle\Entity\Parameter;
use ProjectManager\ParameterBundle\Form\ParameterType;

class DefaultController extends Controller
{
    const bundleName = 'ProjectManagerParameterBundle';
    const entityName = 'Parameter';
    const indexRoute = 'project_manager_parameter';
    const repository = 'ProjectManager\ParameterBundle\Entity\Parameter';
    
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getManager()
                ->getRepository('ProjectManagerParameterBundle:Parameter');

        $parametersList = $repository->findAll();

        return $this
                ->render('ProjectManagerParameterBundle:Default:index.html.twig',
                        array('parametersList' => $parametersList));
    }
    
    public function addAction()
    {
        return $this->formAction(new Parameter(), 'Ajouter un paramètre');
    }
    
    public function modifyAction($id)
    {
        // récupération des données via l'id du paramètre sélectionné
        $parameter = $this->getDoctrine()
        ->getRepository(self::repository)->find($id);
    
        return $this->formAction($parameter, 'Modifier un paramètre');
    }
    
    private function formAction($parameter, $description)
    {
        $form = $this->createForm(new ParameterType(), $parameter);
    
        // récupération de la requête
        $request = $this->get('request');
    
        // vérification du type de la requete
        if ($request->getMethod() == 'POST') {
            // execution de la requete
            $form->bind($request);
    
            // vérification de la validité des données saisies
            if ($form->isValid()) {
                // enregistrement de l'objet $parameter dans la BD
                $em = $this->getDoctrine()->getManager();
                $em->persist($parameter);
                $em->flush();
    
                // redirection vers la page de visualisation de la liste des paramètres
                return $this->redirect($this->generateUrl(self::indexRoute));
            }
        }
    
        // - si requete de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
        // - si requete de type POST, mais le formulaire n'est pas valide, donc on l'affiche de nouveau
        return $this
        ->render('ProjectManagerParameterBundle:Default:form.html.twig',
                array('form' => $form->createView(),
                        'description'=> $description,
                        'index_route' => self::indexRoute));
    }
    
    
}
