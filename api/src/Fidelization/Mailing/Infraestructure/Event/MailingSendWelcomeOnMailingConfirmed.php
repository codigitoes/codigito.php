<?php

declare(strict_types=1);

namespace Codigito\Fidelization\Mailing\Infraestructure\Event;

use Codigito\Shared\Domain\Event\DomainEvent;
use Codigito\Shared\Domain\Event\DomainEventEnum;
use Codigito\Shared\Domain\Event\DomainEventSubscriber;
use Codigito\Shared\Infraestructure\Service\MailerSenderSymfony;

class MailingSendWelcomeOnMailingConfirmed implements DomainEventSubscriber
{
    public function __construct(private readonly MailerSenderSymfony $mailer)
    {
    }

    public function handlerEvent(DomainEvent $event): void
    {
        $from    = 'codigito@gmail.com';
        $to      = $event->payload->value['email'];
        $subject = 'Bienvenido al mailing. Ahora estarás al día !';
        $html    = '<p>Haz click  <a href="'.rtrim($_ENV['WWW_URL'], '/').'/list">"aqui"</a> para ir a ver nuestro contenido!!';

        $this->mailer->send($from, $to, $subject, $html);
    }

    public function subscribedTo(): array
    {
        return [DomainEventEnum::MAILING_CONFIRMED];
    }
}
