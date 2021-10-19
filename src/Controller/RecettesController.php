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
     * @Route("/home", name="home")
     */
    public function home(): Response
    {
        if($this->getUser() && !$this->getUser()->isVerified()){
            return $this->redirectToRoute("app_logout");
        }
        return $this->render('recettes/home.html.twig');
    }

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
            $em->persist($recette);
            $em->flush();
            $this->addFlash("success", "La recette a bien été ajoutée");
            return $this->redirectToRoute("list", [ "type" => $recette->getType() ]);
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
            $em->flush();
            $this->addFlash("success", "La recette a bien été mise à jour");
            return $this->redirectToRoute("list", [ "type" => $recette->getType() ]);
        }
        return $this->render('recettes/update.html.twig', [ "form" => $form->createView() ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete($id, RecettesRepository $repo, EntityManagerInterface $em): Response
    {
        $recette = $repo->find($id);
        $em->remove($recette);
        $em->flush();
        $this->addFlash("success", "La recette a bien été supprimée");
        return $this->redirectToRoute("list", [ "type" => $recette->getType() ]);
    }
}
