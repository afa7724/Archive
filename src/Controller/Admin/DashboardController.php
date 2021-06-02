<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Archive;
use App\Entity\Filiere;
use App\Entity\Etudiant;
use App\Entity\Professeur;
use App\Controller\Admin\UserCrudController;
use Symfony\Component\HttpFoundation\Response;
use App\Controller\Admin\ArchiveCrudController;
use App\Controller\Admin\FiliereCrudController;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Admin\EtudiantCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use App\Controller\Admin\ProfesseurCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\Component\Security\Core\User\UserInterface;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/front/end/admin", name="admin")
     */
    public function index(): Response
    {

        // redirect to some CRUD controller
        $routeBuilder = $this->get(AdminUrlGenerator::class);
        return $this->redirect($routeBuilder->setController(UserCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            // // the name visible to end users
            ->setTitle('Archive');
        // // you can include HTML contents too (e.g. to link to an image)
        // ->setTitle('<img src="..."> ACME <span class="text-small">Corp.</span>')

        // the path defined in this method is passed to the Twig asset() function
        // ->setFaviconPath('Treetog-I-ZIP-File.ico');


    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Table de bord', 'fa fa-home'),

            MenuItem::section('Blog', 'fa fa-list'),
            MenuItem::linkToCrud('Filiere', 'fa fa-tags', Filiere::class),
            MenuItem::linkToCrud('Archive', 'fa fa-file-text', Archive::class),

            MenuItem::section('Utilisateurs', 'fa fa-user-friends'),
            MenuItem::linkToCrud('Users', 'fa fa-user', User::class),
            MenuItem::linkToCrud('Etudiant', 'fa fa-user', Etudiant::class),
            MenuItem::linkToCrud('Professeur', 'fa fa-user', Professeur::class),

        ];
    }
    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)->addMenuItems([
            MenuItem::linkToRoute('Parametre', 'fa fa-id-card', 'app_account_change_password'),

        ])
            ->displayUserName(false);
    }
}
