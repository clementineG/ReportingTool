<?php

namespace ProjectManager\ParameterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use ProjectManager\ParameterBundle\Entity\PossibleValue;
use ProjectManager\ParameterBundle\Form\PossibleValueType;

class PossibleValueController extends Controller
{
    
    const bundleName = 'ProjectManagerParameterBundle';
    const entityName = 'PossibleValue';
    const indexRoute = 'project_manager_possiblevalues';
    const repository = 'ProjectManagerParameterBundle:PossibleValue';

    public function indexAction($parameter_id)
    {
        $parameter = $this->getParameter($parameter_id);

        $repository = $this->getDoctrine()->getManager()
                ->getRepository(self::repository);

        //selection des valeurs correspondantes au paramètre donné
        $possibleValueList = $repository->findBy(array('parameter' => $parameter_id));;

        return $this
                ->render('ProjectManagerParameterBundle:PossibleValue:index.html.twig',
                        array('parameter' => $parameter,
                                'parameter_id'=>$parameter_id,
                                'possibleValueList' => $possibleValueList));
    }

    public function addAction($parameter_id)
    {
        $parameter = $this->getParameter($parameter_id);

        $possibleValue = new PossibleValue();
        $possibleValue->setParameter($parameter);

        return $this->formAction($parameter,$parameter_id, $possibleValue, 'Ajouter une valeur possible au paramètre ' . $parameter->getName());
    }

    public function modifyAction($id, $parameter_id)
    {
        $parameter = $this->getParameter($parameter_id);
        
        $possibleValue = $this->getDoctrine()->getRepository(self::repository)
                ->find($id);

        return $this
                ->formAction($parameter, $parameter_id, $possibleValue, 'Modifier une valeur du paramètre ' . $parameter->getName());
    }

    public function removeAction($id, $parameter_id)
    {
        //TODO
    }

    private function formAction($parameter, $parameter_id, $possibleValue, $description)
    {
        $form = $this->createForm(new PossibleValueType(), $possibleValue);

        // récupération de la requête
        $request = $this->get('request');

        // vérification du type de la requete
        if ($request->getMethod() == 'POST') {
            // execution de la requete
            $form->bind($request);

            // vérification de la validité des données saisies
            if ($form->isValid()) {
                // enregistrement de l'objet $possibleValue dans la BD
                $em = $this->getDoctrine()->getManager();
                $em->persist($possibleValue);
                $em->flush();

                // redirection vers la page de visualisation de la liste des valeurs possibles
                return $this->redirect($this->generateUrl(self::indexRoute));
            }
        }

        // - si requete de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
        // - si requete de type POST, mais le formulaire n'est pas valide, donc on l'affiche de nouveau
        return $this
                ->render(
                        'ProjectManagerParameterBundle:PossibleValue:form.html.twig',
                        array('parameter' => $parameter,
                                'parameter_id' => $parameter_id,
                                'form' => $form->createView(),
                                'description' => $description,
                                'index_route' => self::indexRoute));
    }

    private function getParameter($parameter_id)
    {
        // récupération de l'objet paramètre pour lequel on souhaite ajouter une valeur possible
        return $this->getDoctrine()
                ->getRepository('ProjectManagerParameterBundle:Parameter')
                ->find($parameter_id);
    }
}
