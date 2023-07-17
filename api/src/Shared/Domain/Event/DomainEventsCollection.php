<?php

declare(strict_types=1);

namespace Codigito\Shared\Domain\Event;

use Codigito\Shared\Domain\Exception\InvalidEventException;

final class DomainEventsCollection
{
    public function __construct(private array $events = [])
    {
        foreach ($events as $anEvent) {
            if ($anEvent instanceof DomainEvent) {
                continue;
            }

            throw new InvalidEventException(json_encode($anEvent));
        }
    }

    public function push(DomainEvent $event): void
    {
        $this->events[] = $event;
    }

    public function toArray(): array
    {
        return $this->events;
    }

    public function clear(): void
    {
        $this->events = [];
    }
}
