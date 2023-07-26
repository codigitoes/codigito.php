<?php

declare(strict_types=1);

namespace Codigito\Shared\Domain\Event;

use Codigito\Shared\Domain\Exception\InternalErrorException;

final class DomainEventsCollection
{
    public function __construct(private array $events = [])
    {
        foreach ($events as $anEvent) {
            if ($anEvent instanceof DomainEvent) {
                continue;
            }

            throw new InternalErrorException('invalid event: '.json_encode($anEvent));
        }
    }

    public function push(DomainEvent $event): void
    {
        $this->events[] = $event;
    }

    public function all(): array
    {
        return $this->events;
    }

    public function clear(): void
    {
        $this->events = [];
    }
}
