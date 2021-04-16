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
     * @Route("/app/user/logout", name="app_security_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }



    // /**
    //  * @Route("/app/user/register", name="app_security_register" , schemes={"https"})
    //  */
    // public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, AppCustomAuthenticator $authenticator, \Swift_Mailer $mailer, GuardAuthenticatorHandler $guardHandler): Response
    // {
    //     if ($this->getUser()) {
    //         return $this->redirectToRoute('app_archives_home_page');
    //     }

    //     $etudiant = new Etudiant();
    //     $form = $this->createForm(EtudiantType::class, $etudiant);
    //     $form->handleRequest($request);


    //     if ($form->isSubmitted() && $form->isValid()) {
    //         // encode the plain password   

    //         $etudiant->setPassword(
    //             $passwordEncoder->encodePassword(
    //                 $etudiant,
    //                 $form["foo"]["password"]->getData()
    //             )
    //         );
    //         // On génère un token et on l'enregistre
    //         $etudiant->setActivationToken(md5(uniqid()));
            
    //         //save the  in the database
    //         $this->manager->persist($etudiant);
    //         $this->manager->flush();

    //         // do anything else you need here, like send an email
    //         // On crée le message
    //         $message = (new \Swift_Message('Nouveau compte'))
    //             // On attribue l'expéditeur
    //             ->setFrom('noreplyarchive3@gmail.com')
    //             // On attribue le destinataire
    //             ->setTo($etudiant->getEmail())
    //             // On crée le texte avec la vue cad ce le fichier activation qui va contenir le corps de l'email envoie a l'
    //             ->setBody(
    //                 $this->renderView(
    //                     'emails/activation.html.twig',
    //                     ['token' => $etudiant->getActivationToken()]
    //                 ),
    //                 'text/html'
    //             );
    //         //sending the message
    //         $mailer->send($message);


    //         // authentifie manuellement l'utilisateur 

    //         return $guardHandler->authenticateUserAndHandleSuccess(
    //             $etudiant,          // the User object you just created
    //             $request,
    //             $authenticator, // authenticator whose onAuthenticationSuccess you want to use
    //             'main'          // the name of your firewall in security.yaml
    //         );
    //     }
    //     //le formulaire a remplir
    //     return $this->render('registration/register.html.twig', [
    //         'registrationForm' => $form->createView(),
            
    //     ]);
    // }


    //  /**
    //  * le token est celui gere dans la fonction register et sera envoie comme lien
    //  * @Route("/app/user/activation/{token}", name="app_security_activation")
    //  */
    // public function activation($token, AppCustomAuthenticator $authenticator, GuardAuthenticatorHandler $guardHandler, Request $request)
    // {
        
    //     // On recherche si un utilisateur avec ce token existe dans la base de données
    //     $user = $this->userRepository->findOneBy(['activationtoken' => $token]);

    //     // Si aucun utilisateur n'est associé à ce token
    //     if (!$user) {
    //         // On renvoie une erreur 404
    //         throw $this->createNotFoundException('Cet utilisateur n\'existe pas');
    //     }
       
    //         // On supprime le token
    //     $user->setActivationToken(null);
    //     //on attrabut un role d'activation a l'user
    //     if ($user instanceof Etudiant) 
    //         $user->setRoles(['ROLE_USER']);
        
    //     if ($user instanceof Professeur) 
    //         $user->setRoles(['ROLE_PROFESSEUR']);
            
    //     //enregistre le changement dans la base
    //     $user->setIsVerified(true);
    //     $this->manager->persist($user);
    //     $this->manager->flush();
    //     $this->addFlash('message', 'Compte Active');
    //     return $this->redirectToRoute('app_security_login');
        

        
    //     if (!$this->getUser()) {
    //         return $this->redirectToRoute('app_security_login');
    //     } else {
    //         return $this->redirectToRoute('app_security_activationForce');
    //     }
    // }

    //  /**
    //  * On recupere le compte avec l'email
    //  * @Route("/oubli-pass", name="app_forgotten_password")
    //  */
    // public function oubliPass(Request $request,\Swift_Mailer $mailer,TokenGeneratorInterface $tokenGenerator ): Response {

    //     // On initialise le formulaire
    //     $form = $this->createForm(ResetPassType::class);

    //     // On traite le formulaire
    //     $form->handleRequest($request);

    //     // Si le formulaire est valide
    //     if ($form->isSubmitted() && $form->isValid()) {
    //         // On récupère les données
    //         $donnees = $form->getData();

    //         // On cherche un utilisateur ayant cet e-mail
    //         $user = $this->repository->findOneByEmail($donnees['email']);

    //         // Si l'utilisateur n'existe pas
    //         if ($user === null) {
    //             // On envoie une alerte disant que l'adresse e-mail est inconnue
    //             $this->addFlash('danger', 'Cette adresse e-mail est inconnue');

    //             // Reste sur la page pour entre un nouveau mail
    //             return $this->redirectToRoute('app_forgotten_password', [], 301);
    //         }

    //         // On génère un token
    //         $token = $tokenGenerator->generateToken();

    //         // On essaie d'écrire le token en base de données
    //         try {
    //             $user->setResetToken($token);
    //             $this->manager->persist($user);
    //             $this->manager->flush();
    //         } catch (\Exception $e) {
    //             $this->addFlash('warning', $e->getMessage());
    //             return $this->redirectToRoute('app_login');
    //         }
    //         // On génère l'e-mail
    //         $message = (new \Swift_Message('Mot de passe oublié'))
    //             ->setFrom('ovd.officiel190@gmail.com')
    //             ->setTo($user->getEmail())
    //             ->setBody(
    //                 $this->renderView(
    //                     'emails/resetpass.html.twig',
    //                     ['token' => $user->getResetToken()]
    //                 ),
    //                 'text/html'
    //             );

    //         // On envoie l'e-mail
    //         $mailer->send($message);

    //         // On crée le message flash de confirmation
    //         $this->addFlash('message', 'E-mail de réinitialisation du mot de passe envoyé !');

    //         // On redirige vers la page de login
    //         return $this->redirectToRoute('app_login');
    //     } //fermetur de la condition de validation form

    //     // On envoie le formulaire à la vue
    //     return $this->render('security/forgotten_password.html.twig', ['emailForm' => $form->createView()]);
    // }

    // /**
    //  * @Route("app/user/reset_pass/{token}", name="app_security_reset_password")
    //  */
    // public function resetPassword(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder): Response
    // {
    //     // On cherche un utilisateur avec le token donné
    //     $user = $this->userRepository->findOneBy(['reset_token' => $token]);

    //     // Si l'utilisateur n'existe pas
    //     if ($user === null) {
    //         // On affiche une erreur
    //         $this->addFlash('danger', 'Token Inconnu');
    //         return $this->redirectToRoute('app_login');
    //     }

    //     // Si le formulaire est envoyé en méthode post
    //     //On genere le formulaire
    //     $form = $this->createForm(ResetPassAfterType::class);

    //     // On traite le formulaire
    //     $form->handleRequest($request);
    //     //Recuperation de donnee (saisi)
    //     $pass = $form->get('password')->getData();
    //     $com = $form->get('confirmepassword')->getData();
    //     //sinon on verifie la contraint de l'heure 

    //     $time = $user->getUpdateAt();



    //     $datetime2 = new DateTime('now');
    //     $interval = $time->diff($datetime2);

    //     $in = $interval->format('%R%a%H%M%S');

    //     if ($in == '-1000000' || substr($in, 0, 2) == '-0') {
    //         // Si le formulaire est valide
    //         if ($form->isSubmitted() && $form->isValid() && $pass == $com) {
    //             // On supprime le token
    //             $user->setResetToken(null);
    //             // On chiffre le mot de passe
    //             $user->setPassword(
    //                 $passwordEncoder->encodePassword(
    //                     $user,
    //                     $form->get('password')->getData()
    //                 )
    //             );
    //             // On stocke
    //             $this->manager->persist($user);
    //             $this->manager->flush();

    //             // On crée le message flash
    //             $this->addFlash('message', 'Mot de passe mis à jour');
    //             //disconnected the user
    //             $this->get('security.token_storage')->getToken()->setAuthenticated(false);
    //             // On redirige vers la page de connexion
    //             return $this->redirectToRoute('app_login');
    //         } else {
    //             if (!is_null($pass) && !is_null($com)) {
    //                 // On crée le message flash affiche dans la le form
    //                 $this->addFlash('errer', 'Mot de passe different');
    //             }
    //             // Si on n'a pas reçu les données, on affiche le formulaire
    //             return $this->render('security/reset_password.html.twig', ['form' => $form->createView()]);
    //         }
    //     }
    //     $this->addFlash('danger', 'Token expire');
    //     return $this->redirectToRoute('app_login');
    // }



    /**
     * le token est celui gere dans la fonction register et sera envoie comme lien
     * @Route("/app/user/activationforce", name="app_security_activationforce")
     */
    public function activationForce()
    {
        $this->denyAccessUnlessGranted("ROLE_UNACTIVATED");
        return $this->render('registration/ActivationForce.html.twig');
    }


}
