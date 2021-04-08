<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArchivesController extends AbstractController
{
    /**
     * @Route("/", name="app_archives_home_page")
     */
    public function index(): Response
    {
        return $this->render('archives/home_page.html.twig', [
            'controller_name' => 'ArchivesController',
        ]);
    }
}
