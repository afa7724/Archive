<?php

namespace App\EventListener;

use App\Entity\Etudiant;
use App\Entity\Professeur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class RequestListener
{

    /**
     * @var \Symfony\Component\Routing\UrlGeneratorInterface
     */
    private $router;
    /**
     * Undocumented variable
     *
     * @var \Doctrine\ORM\EntityManagerInterface;
     */
    private $em;

    private $authorizationChecker;

    /**
     * @InjectParams({
     *     "authorizationChecker" = @Inject ("security.token_storage")
     * })
     */
    public function __construct(EntityManagerInterface $em, UrlGeneratorInterface $router, TokenStorageInterface $authorizationChecker)
    {
        $this->em = $em;
        $this->router = $router;
        $this->authorizationChecker = $authorizationChecker;
    }
    /**
     * Permet de garde l'utilisateur non active sur la page activeforce
     *
     * @param RequestEvent $event
     * @return void
     */
    public function onKernelRequest(RequestEvent $event)
    {
        //Recupere la router courant
        $currentRoute = $event->getRequest()->attributes->get('_route');
        $token = $this->authorizationChecker->getToken();
        $user = $token ? $token->getUser() : null;

        if ($user) {



            $active =  $user->isVerified();

            // $role2 = in_array('ROLE_BLOQUE', $user->getRoles());
            // Redirige vers soit le deconnecte activation force 
            if (!$active && !$this->isAuthenticatedUser($currentRoute)) {

                $event->setResponse(new RedirectResponse($this->router->generate('app_registration_check_email')));
            }
            //Rediger vers le home si deja active
            if ($active && $this->isConnectUser($currentRoute)) {

                $event->setResponse(new RedirectResponse($this->router->generate('app_archives_home_page')));
            }
        }
    }

    private function isAuthenticatedUser($currentRoute)
    {
        return in_array(
            $currentRoute,
            ['app_security_logout', 'app_verify_email', 'app_registration_check_email']
        );
    }


    private function isConnectUser($currentRoute)
    {
        return in_array(
            $currentRoute,
            ['app_register', 'app_verify_email', 'app_registration_check_email', 'app_security_login', 'home']
        );
    }
}
