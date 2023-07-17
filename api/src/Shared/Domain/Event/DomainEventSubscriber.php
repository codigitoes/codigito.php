<?php

declare(strict_types=1);

namespace Codigito\Shared\Domain\Event;

use Codigito\Shared\Domain\ValueObject\DomainEventName;

interface DomainEventSubscriber
{
    public function subscribedTo(DomainEventName $name): bool;
    public function execute(DomainEvent $event): void;
}
