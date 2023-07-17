<?php

declare(strict_types=1);

namespace Codigito\Shared\Domain\Event;

interface Eventuable
{
    public function pullEvents(): DomainEvents;
}
