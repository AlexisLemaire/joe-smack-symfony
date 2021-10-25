<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        if($this->getUser() && !$this->getUser()->isVerified()){
            return $this->redirectToRoute("app_logout");
        }
        return $this->render('home.html.twig');
    }

    /**
     * @Route("/home", name="home")
     */
    public function home(): Response
    {
        if($this->getUser() && !$this->getUser()->isVerified()){
            return $this->redirectToRoute("app_logout");
        }
        return $this->render('home.html.twig');
    }
}
