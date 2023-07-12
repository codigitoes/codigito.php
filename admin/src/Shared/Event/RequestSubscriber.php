<?php

declare(strict_types=1);

namespace App\Shared\Event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class RequestSubscriber implements EventSubscriberInterface
{
    private const PUBLIC_ROUTES = [
        'login_index',
    ];

    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest() || in_array($event->getRequest()->get('_route'), self::PUBLIC_ROUTES)) {
            return;
        }

        $session = $event->getRequest()->getSession();
        $sessionTimeout = $session->get('token_timeout', null);
        if (is_null($sessionTimeout)) {
            $event->setResponse(new RedirectResponse('/login'));

            return;
        }

        if ($sessionTimeout - time() < 0) {
            $session->clear();
            $event->setResponse(new RedirectResponse('/login'));
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }
}
