<?php

declare(strict_types=1);

namespace Codigito\Shared\Domain\Event;

interface DomainEventBus
{
    public function publish(DomainEventsCollection $events): void;
}
