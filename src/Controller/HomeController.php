<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController{
    /**
     * @return Response
     */
    #[Route('/', 'home.index', methods:['GET'])]
    public function index():Response{
        return $this->render('home.html.twig');
    }

//    je l'ai cree en guise de test
    #[Route('diam', 'diam.index', methods: ['GET'])]
    public function router():Response{
        return $this->render("diam.html.twig");
    }
}


