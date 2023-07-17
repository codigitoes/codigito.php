<?php

declare(strict_types=1);

namespace Codigito\Shared\Domain\Event;

class DomainEvent
{
    public function __construct(public readonly array $events)
    {
    }
}
