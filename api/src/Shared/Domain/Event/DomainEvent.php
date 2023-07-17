<?php

declare(strict_types=1);

namespace Codigito\Shared\Domain\Event;

use Codigito\Shared\Domain\ValueObject\DomainEventId;
use Codigito\Shared\Domain\ValueObject\DomainEventName;
use Codigito\Shared\Domain\ValueObject\DomainEventPayload;
use DateTime;

class DomainEvent
{
    public function __construct(
        public readonly DomainEventId $id,
        public readonly DomainEventName $name,
        public readonly DomainEventPayload $payload,
        public readonly DateTime $ocurredOn
    ) {
    }
}
