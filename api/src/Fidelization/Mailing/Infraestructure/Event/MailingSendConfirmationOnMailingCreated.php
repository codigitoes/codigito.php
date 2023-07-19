<?php

declare(strict_types=1);

namespace Codigito\Fidelization\Mailing\Infraestructure\Event;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Codigito\Shared\Domain\Event\DomainEvent;
use Codigito\Shared\Domain\Event\DomainEventEnum;
use Codigito\Shared\Domain\Event\DomainEventSubscriber;

class MailingSendConfirmationOnMailingCreated implements DomainEventSubscriber
{
    public function __construct(private readonly MailerInterface $mailer)
    {
    }

    public function subscribedTo(): array
    {
        return [DomainEventEnum::MAILING_CREATED];
    }

    public function handlerEvent(DomainEvent $event): void
    {
        $email = (new Email())
            ->from('codigito@gmail.com')
            ->to($event->payload->value['email'])
            ->subject('Confirmacion de subscripcion al mailing!')
            ->text('Este email es para confirmar que no te estan gastando una broma y quieres subscribirte :)')
            ->html('<p>Haz click <a href="'.rtrim($_ENV['WWW_URL'], '/').'/suscription/'.$event->payload->value['id'].'/confirm">"aqui"</a> para confirmar tu suscripcion!!');

        // $this->mailer->send($email);
    }
}
