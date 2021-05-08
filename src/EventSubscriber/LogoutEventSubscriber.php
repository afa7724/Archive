<?php

namespace App\EventSubscriber;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Event\LogoutEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LogoutEventSubscriber implements EventSubscriberInterface
{
    private $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function onLogoutEvent(LogoutEvent $event)
    {
        $event->getRequest()->getSession()->getFlashBag()->add(
            'success',
            'Déconnecté avec succès!'
        );
        
        $event->setResponse(new RedirectResponse($this->urlGenerator->generate('app_security_login')));
    }

    public static function getSubscribedEvents()
    {
        return [
            LogoutEvent::class => 'onLogoutEvent',
        ];
    }
}
