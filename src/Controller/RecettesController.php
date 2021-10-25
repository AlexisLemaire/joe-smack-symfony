<?php

namespace App\Controller;

use App\Entity\Recettes;
use App\Form\AjoutRecetteFormType;
use App\Repository\RecettesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/recettes", name="recettes_")
*/
class RecettesController extends AbstractController
{
    /**
     * @Route("/recette/{id}", name="recette")
     */
    public function recette($id, RecettesRepository $repo): Response
    {
        $recette = $repo->find($id);
        return $this->render('recettes/recette.html.twig', [ "recette" => $recette ]);
    }

    /**
     * @Route("/list/{type}", name="list")
     */
    public function list($type, RecettesRepository $repo): Response
    {
        if($type == "az"){
            $recettes = $repo->findAll();
        } else {
            $recettes = $repo->findBy(["type" => $type]);
        }
        return $this->render('recettes/list.html.twig', [ "recettes" => $recettes, "type" => $type ]);
    }

    /**
     * @Route("/ajout", name="ajout")
     */
    public function ajout(Request $request, EntityManagerInterface $em): Response
    {
        $recette = new Recettes();
        $form = $this->createForm(AjoutRecetteFormType::class, $recette);
        $form->handleRequest($request); 

        if($form->isSubmitted() && $form->isValid()){
            if(!$this->getUser()){
                $this->addFlash("danger", "Vous devez être connecté avec un compte administrateur pour ajouter une recette");
            }
            else if(!in_array("ROLE_ADMIN",$this->getUser()->getRoles())){
               $this->addFlash("danger", "Vous devez être administrateur pour ajouter une recette");
            } else {
                $img = $form['img']->getData();
                if($img){
                    $img->move("../public/img/", $img->getClientOriginalName());
                    $recette->setImgName($img->getClientOriginalName());
                }
                $em->persist($recette);
                $em->flush();
                $this->addFlash("success", "La recette a bien été ajoutée");
                return $this->redirectToRoute("recettes_list", [ "type" => $recette->getType() ]);
            }
        }
        return $this->render('recettes/ajout.html.twig', [ "form" => $form->createView() ]);
    }

    /**
     * @Route("/update/{id}", name="update")
     */
    public function update($id, Request $request, EntityManagerInterface $em, RecettesRepository $repo): Response
    {
        $recette = $repo->find($id);
        $form = $this->createForm(AjoutRecetteFormType::class, $recette);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if(!$this->getUser()){
                $this->addFlash("danger", "Vous devez être connecté avec un compte administrateur pour modifier une recette");
            }
            else if(!in_array("ROLE_ADMIN",$this->getUser()->getRoles())){
                $this->addFlash("danger", "Vous devez être administrateur pour modifier une recette");
            } else {
                $img = $form['img']->getData();
                if($img){
                    $img->move("../public/img/", $img->getClientOriginalName());
                    $recette->setImgName($img->getClientOriginalName());
                }
                $em->flush();
                $this->addFlash("success", "La recette a bien été mise à jour");
                return $this->redirectToRoute("recettes_list", [ "type" => $recette->getType() ]);
            } 
        }
        return $this->render('recettes/update.html.twig', [ "form" => $form->createView(), "recette" => $recette ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete($id, RecettesRepository $repo, EntityManagerInterface $em): Response
    {
        if(in_array("ROLE_ADMIN",$this->getUser()->getRoles())){
            $recette = $repo->find($id);
            $em->remove($recette);
            $em->flush();
            $this->addFlash("success", "La recette a bien été supprimée");
            return $this->redirectToRoute("recettes_list", [ "type" => $recette->getType() ]);
        } else {
            $this->addFlash("danger", "Vous devez être administrateur pour supprimer une recette");
            return $this->redirectToRoute("recettes_recette", [ "id" => $id]);
        }
        
    }
}
