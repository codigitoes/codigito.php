<?php

declare(strict_types=1);

namespace Codigito\Shared\Domain\Event;

use Codigito\Shared\Domain\Exception\InvalidEventException;

final class DomainEvents
{
    public function __construct(public readonly array $events)
    {
        foreach ($events as $anEvent) {
            if ($anEvent instanceof DomainEvent) {
                continue;
            }

            throw new InvalidEventException(json_encode($anEvent));
        }
    }
}
