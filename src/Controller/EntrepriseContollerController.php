<?php

namespace App\Controller;


use App\Entity\Entreprise;
use App\Form\EntrepriseType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class EntrepriseContollerController extends AbstractController
{
    /**
     * @Route("/entreprise/contoller", name="app_entreprise")
     */
    public function index(ManagerRegistry $doctrine): Response
    {

        // récupérer toutes les entreprises de la base de donnée
        $entreprises = $doctrine->getRepository(Entreprise::class)->findAll();
        return $this->render('entreprise_contoller/index.html.twig', [
            'entreprises' => $entreprises
        ]);

        // SELECT * FROM employe ORDER BY raisonSociale ASC
        // $entreprises = $doctrine->getRepository(Entreprise::class)->findBy([], ['raisonSociale' => 'ASC']);
        // return $this->render('entreprise_contoller/index.html.twig', [
        //     'entreprises' => $entreprises
        // ]);
    }

    
    // on peut avoir plusieurs Routes pour une method
    /**
     * @Route("/entreprise/add", name="add_entreprise")
     * @Route("/entreprise/{id}/edit", name="edit_entreprise") 
     */

    // $doctrine -> reagir avec la base de donné  
    // $entreprise -> quel type d'element ajouter(ce sera un object et pas un array)
    // $request -> pour analyser les données
    public function add(ManagerRegistry $doctrine, Entreprise $entreprise = null, Request $request): Response{
        
        if(!$entreprise) { 
            $entreprise = new Entreprise();
        }
        
        // il se base sur la classe EntrepriseType(->$builder) et l'object Entreprise
        $form = $this->createForm(EntrepriseType::class, $entreprise); //création de formulaire
        $form->handleRequest($request); // quand il y a une action effectué(avant la soumission) sur le formulaire il analyse ce que la requête récupère

        // Traitement de formulaire
        if($form->isSubmitted() && $form->isValid()) {

            // donner les valeurs de form à l'entreprise
            $entreprise = $form->getData();
            // pour acceder au persist() et flush()
            $entityManager = $doctrine->getManager();
            // equivalent prepare() dans PDO (préparation des données)
            $entityManager->persist($entreprise);
            // equivalent execute() dans PDO (envoi et mise à jour des données)
            $entityManager->flush();
            // refaire la direction vers la liste des entreprises
            return $this->redirectToRoute('app_entreprise');
        }


        
        // Afficher le formulaire d'ajout
        // afficher dans la page add.html.twig
        return $this->render('entreprise_contoller/add.html.twig', [
            // variable formAddEntreprise a comme valeur la création de Vue de Form
            'formAddEntreprise' => $form->createView(),
            // si on envoi un id vers la page add.html.twig, on sera dans le cas edit et la relation ci-dessous sera true.
            'edit' => $entreprise->getId()
        ]);
    }

    /**
     * @Route("/entreprise/{id}/delete", name="delete_entreprise")
     */

    public function delete(ManagerRegistry $doctrine, Entreprise $entreprise) { 
        $entityManager = $doctrine->getManager(); 
        $entityManager->remove($entreprise); 
        $entityManager->flush();  
        return $this->redirectToRoute('app_entreprise');
     }

    // le mettre à la fin de class car on cherche le détail(lecture de code).
    // passer un paramètre dans l'URL
    /**
     * @Route("/entreprise/ {id}", name="show_entreprise")
     */
    public function show(Entreprise $entreprise): Response
    {
        return $this -> render('entreprise_contoller/show.html.twig', [
            'entreprise' => $entreprise
        ]);
    }
}