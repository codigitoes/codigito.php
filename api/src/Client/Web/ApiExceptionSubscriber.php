<?php

declare(strict_types=1);

namespace Codigito\Client\Web;

use Codigito\Shared\Domain\Exception\DomainException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ApiExceptionSubscriber implements EventSubscriberInterface
{
    public function onKernelException(ExceptionEvent $event)
    {
        $th = $event->getThrowable();

        $code = Response::HTTP_INTERNAL_SERVER_ERROR;
        if ($th instanceof DomainException) {
            $code = $th->getErrorCode();
        }

        $response = new JsonResponse(
            ['errors' => [$th->getMessage()]],
            $code
        );
        $response->headers->set('Content-Type', 'application/problem+json');
        $event->setResponse($response);
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }
}
