<?php

declare(strict_types=1);

namespace Codigito\Fidelization\Mailing\Infraestructure\Event;

use Codigito\Shared\Domain\Event\DomainEvent;
use Codigito\Shared\Domain\Event\DomainEventEnum;
use Codigito\Shared\Domain\Event\DomainEventSubscriber;

class MailingSendConfirmationOnMailinCreated implements DomainEventSubscriber
{
    public function subscribedTo(): array
    {
        return [DomainEventEnum::MAILING_CREATED];
    }

    public function handlerEvent(DomainEvent $event): void
    {
        file_put_contents('/tmp/debug', json_encode($event->payload->value));
    }
}
