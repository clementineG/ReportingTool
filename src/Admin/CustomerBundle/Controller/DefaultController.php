<?php

namespace Admin\CustomerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Admin\CustomerBundle\Entity\Customer;
use Admin\CustomerBundle\Form\CustomerType;

class DefaultController extends Controller
{
    const bundleName = 'AdminCustomerBundle';
    const entityName = 'Customer';
    const indexRoute = 'admin_customer';
    const repository = 'Admin\CustomerBundle\Entity\Customer';
    
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getManager()
                ->getRepository('AdminCustomerBundle:Customer');

        $customersList = $repository->findAll();

        return $this
                ->render('AdminCustomerBundle:Default:index.html.twig',
                        array('customersList' => $customersList));
    }
    
    public function addAction()
    {
        return $this->formAction(new Customer(), 'Ajouter un client');
    }

    public function modifyAction($id)
    {
        // récupération des données via l'id de l'utilisateur sélectionné
        $customer = $this->getDoctrine()
                ->getRepository(self::repository)->find($id);
    
        return $this->formAction($customer, 'Modifier un client');
    }
        
    private function formAction($customer, $description)
    {
        $form = $this->createForm(new CustomerType(), $customer);
    
        // récupération de la requête
        $request = $this->get('request');
    
        // vérification du type de la requete
        if ($request->getMethod() == 'POST') {
            // execution de la requete
            $form->bind($request);
    
            // vérification de la validité des données saisies
            if ($form->isValid()) {
                // enregistrement de l'objet $customer dans la BD
                $em = $this->getDoctrine()->getManager();
                $em->persist($customer);
                $em->flush();
    
                // redirection vers la page de visualisation de la liste des utilisateurs
                return $this->redirect($this->generateUrl(self::indexRoute));
            }
        }
    
        // - si requete de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
        // - si requete de type POST, mais le formulaire n'est pas valide, donc on l'affiche de nouveau
        return $this
        ->render('AdminCustomerBundle:Default:form.html.twig',
                array('form' => $form->createView(),
                        'description'=> $description,
                        'index_route' => self::indexRoute));
    }
    
    
}
