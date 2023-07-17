<?php

declare(strict_types=1);

namespace Codigito\Shared\Domain\Event;

use Codigito\Shared\Domain\ValueObject\DomainEventName;

interface DomainEventHandler
{
    public function appliesTo(DomainEventName $name): bool;
    public function execute(DomainEventName $name): void;
}
