<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Entity\Professeur;
use App\Form\EtudiantType;
use App\Repository\UserRepository;
use App\Security\AppCustomAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class SecurityController extends AbstractController
{
   
   
    private $manager;
    private $userRepository;
    public function __construct(EntityManagerInterface $manager,UserRepository $userRepository)
    {
        $this->manager = $manager;
        $this->userRepository=$userRepository;
       
    }
   
    /**
     * @Route("/", name="app_security_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            $this->addFlash('danger','Déjà connecté');
            return $this->redirectToRoute('app_archives_home_page');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/app/user/logout", name="app_security_logout" ,methods="POST")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }





}
