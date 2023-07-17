<?php

declare(strict_types=1);

namespace Codigito\Shared\Domain\Event;

interface DomainEventSubscriber
{
    public function subscribedTo(): array;

    public function handlerEvent(DomainEvent $event): void;
}
