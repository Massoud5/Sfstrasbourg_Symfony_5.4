<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Form\EmployeType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmployeContollerController extends AbstractController
{
    /**
     * @Route("/employe/contoller", name="app_employe")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        // récupérer toutes les entreprises de la base de donnée
        // $employes = $doctrine->getRepository(Employe::class)->findAll();
        // return $this->render('employe_contoller/index.html.twig', [
        //     'employes' => $employes
        // ]);

        // SELECT * FROM employe WHERE ville = 'SCHILTIGHEIM' ORDER BY nom ASC
        $employes = $doctrine->getRepository(Employe::class)->findBy([], ['nom' => 'ASC']);
        return $this->render('employe_contoller/index.html.twig', [
            'employes' => $employes
        ]);
    }

    /**
     * @Route("/employe/add", name="add_employe")
     * @Route("/employe/{id}/edit", name="edit_employe")
     */

    // $doctrine -> reagir avec la base de donné  
    // $employe -> quel type d'element ajouter(ce sera un object et pas un array)
    // $request -> pour analyser les données
    public function add(ManagerRegistry $doctrine, Employe $employe = null, Request $request): Response{
        
        // dans le cas de ajout de données 
        if(!$employe) {
            $employe = new Employe();
        }

        // on se base sur la classe EmployeType(->$builder) et l'object Employe
        // si l'employe est existant le formulaire sera prérempli
        $form = $this->createForm(EmployeType::class, $employe); //création de formulaire
        // Equivalent PDO: liaison entre l'action effectué(dans index de cinema_pdo) et la method d'une classe  
        $form->handleRequest($request); // quand il y a une action effectué(avant la soumission) sur le formulaire il analyse ce que la requête récupère

        // Traitement de formulaire
        if($form->isSubmitted() && $form->isValid()) {

            // récupérer les données prérempli ou saisi
            $employe = $form->getData();
            // pour acceder au persist() et flush()
            $entityManager = $doctrine->getManager();
            // equivalent prepare() dans PDO (préparation des données)
            $entityManager->persist($employe);
            // equivalent execute() dans PDO (envoi et mise à jour des données)
            $entityManager->flush();
            // refaire la direction vers la liste des employes
            return $this->redirectToRoute('app_employe');
        }


        // Afficher le formulaire d'ajout
        // afficher dans la page add.html.twig
        return $this->render('employe_contoller/add.html.twig', [
            // variable formAddEmploye a comme valeur la création de Vue de Form
            'formAddEmploye' => $form->createView(),
            // si on envoi un id vers la page add.html.twig, on sera dans le cas edit et la relation ci-dessous sera true.
            'edit' => $employe->getId()
        ]);
    }

    
    /**
     * @Route("/employe/{id}/delete", name="delete_employe")
     */

     public function delete(ManagerRegistry $doctrine, Employe $employe) { 
        $entityManager = $doctrine->getManager(); 
        $entityManager->remove($employe); 
        $entityManager->flush();  

        return $this->redirectToRoute('app_employe');
     }


    /**
     * @Route("/employe/{id}", name="show_employe")
     */

    // id en question est récupéré par le paramètre de la method
    public function show(Employe $employe): Response
    {
        return $this -> render('employe_contoller/show.html.twig', [
            'employe' => $employe
        ]);
    }

    
}
