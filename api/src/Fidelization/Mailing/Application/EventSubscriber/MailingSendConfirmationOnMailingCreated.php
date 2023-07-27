<?php

declare(strict_types=1);

namespace Codigito\Fidelization\Mailing\Application\EventSubscriber;

use Codigito\Fidelization\Mailing\Application\MailingSendEmail\MailingSendEmailCommand;
use Codigito\Shared\Domain\Command\CommandBus;
use Codigito\Shared\Domain\Event\DomainEvent;
use Codigito\Shared\Domain\Event\DomainEventEnum;
use Codigito\Shared\Domain\Event\DomainEventSubscriber;

class MailingSendConfirmationOnMailingCreated implements DomainEventSubscriber
{
    public function __construct(private readonly CommandBus $eventor)
    {
    }

    public function subscribedTo(): array
    {
        return [DomainEventEnum::MAILING_CREATED];
    }

    public function handlerEvent(DomainEvent $event): void
    {
        $from    = $_ENV['MAILER_USER'];
        $to      = $event->payload->value['email'];
        $subject = 'Confirmacion de subscripcion al mailing!';
        $html    = '<p>Haz click <a href="' . rtrim($_ENV['WWW_URL'], '/') . '/suscription/' . $event->payload->value['id'] . '/confirm">"aqui"</a> para confirmar tu suscripcion!!';

        $this->eventor->execute(new MailingSendEmailCommand($from, $to, $subject, $html));
    }
}
