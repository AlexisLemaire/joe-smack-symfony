<?php

namespace App\Controller;

use App\Form\ResetPasswordRequestFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteAccountController extends AbstractController
{
    /**
     * @Route("/delete", name="delete_account")
     */
    public function delete(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ResetPasswordRequestFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($form->get('email')->getData() === $user->getEmail()){
                $em->remove($user);
                $em->flush();
                return $this->redirectToRoute('app_login');
            } else {
                $this->addFlash("danger", "L'adresse email entrée n'est pas la bonne");
            }
        }
        return $this->render('delete_account/delete.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
