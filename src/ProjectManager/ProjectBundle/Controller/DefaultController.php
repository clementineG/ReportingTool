<?php

namespace ProjectManager\ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use ProjectManager\ProjectBundle\Entity\Project;
use ProjectManager\ProjectBundle\Form\ProjectType;


class DefaultController extends Controller
{
    const bundleName = 'ProjectManagerProjectBundle';
    const entityName = 'Project';
    const indexRoute = 'project_manager_project';
    const repository = 'ProjectManager\ProjectBundle\Entity\Project';
    
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getManager()
                ->getRepository('ProjectManagerProjectBundle:Project');

        $projectsList = $repository->findAll();

        return $this
                ->render('ProjectManagerProjectBundle:Default:index.html.twig',
                        array('projectsList' => $projectsList));
    }

    public function addAction()
    {
        return $this->formAction(new Project(), 'Ajouter un projet');
    }
    
    public function modifyAction($id)
    {
        // récupération des données via l'id de l'paramètre sélectionné
        $project = $this->getDoctrine()
        ->getRepository(self::repository)->find($id);
    
        return $this->formAction($project, 'Modifier un projet');
    }
    
    private function formAction($project, $description)
    {
        $form = $this->createForm(new ProjectType(), $project);
    
        // récupération de la requête
        $request = $this->get('request');
    
        // vérification du type de la requete
        if ($request->getMethod() == 'POST') {
            // execution de la requete
            $form->bind($request);
    
            // vérification de la validité des données saisies
            if ($form->isValid()) {
                // enregistrement de l'objet $project dans la BD
                $em = $this->getDoctrine()->getManager();
                $em->persist($project);
                $em->flush();
    
                // redirection vers la page de visualisation de la liste des paramètres
                return $this->redirect($this->generateUrl(self::indexRoute));
            }
        }
    
        // - si requete de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
        // - si requete de type POST, mais le formulaire n'est pas valide, donc on l'affiche de nouveau
        return $this
        ->render('ProjectManagerProjectBundle:Default:form.html.twig',
                array('form' => $form->createView(),
                        'description'=> $description,
                        'index_route' => self::indexRoute));
    }
}
