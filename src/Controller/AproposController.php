<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AproposController extends AbstractController
{
    /**
     * @Route("/app/apropos", name="apropos")
     */
    public function index()
    {
        return $this->render('propos/index.html.twig', [
            'controller_name' => 'AproposController',
        ]);
    }
}
