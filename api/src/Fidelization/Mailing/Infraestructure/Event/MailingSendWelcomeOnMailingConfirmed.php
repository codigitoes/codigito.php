<?php

declare(strict_types=1);

namespace Codigito\Fidelization\Mailing\Infraestructure\Event;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Codigito\Shared\Domain\Event\DomainEvent;
use Codigito\Shared\Domain\Event\DomainEventEnum;
use Codigito\Shared\Domain\Event\DomainEventSubscriber;

class MailingSendWelcomeOnMailingConfirmed implements DomainEventSubscriber
{
    public function __construct(private readonly MailerInterface $mailer)
    {
    }

    public function subscribedTo(): array
    {
        return [DomainEventEnum::MAILING_CONFIRMED];
    }

    public function handlerEvent(DomainEvent $event): void
    {
        $email = (new Email())
            ->from('codigito@gmail.com')
            ->to($event->payload->value['email'])
            ->subject('Bienvenido al mailing. Ahora estarás al día !')
            ->text('Este email es para darte la bienvenida al aviso de nuevos contenidos! :)')
            ->html('<p>Haz click  <a href="'.rtrim($_ENV['WWW_URL'], '/').'/list">"aqui"</a> para ir a ver nuestro contenido!!');

        // $this->mailer->send($email);

        dd($email);
    }
}
