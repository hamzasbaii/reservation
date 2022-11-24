<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class indexController extends AbstractController
{
    #[Route('/acceuil', name: 'acceuil')]
    public function index_acceuil()
    {
        return $this->render('acceuil.html.twig');
    }

    #[Route('/annonce', name: 'annonce')]
    public function index_annonce()
    {
        return $this->render('annonce/annonce_front.html.twig');
    }
}
