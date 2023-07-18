<?php

declare(strict_types=1);

namespace Codigito\Shared\Domain\Event;

use Codigito\Shared\Domain\ValueObject\DomainEventId;
use Codigito\Shared\Domain\ValueObject\DomainEventName;
use Codigito\Shared\Domain\ValueObject\DomainEventPayload;

class DomainEvent
{
    private function __construct(
        public readonly DomainEventId $id,
        public readonly DomainEventName $name,
        public readonly DomainEventPayload $payload,
        public readonly \DateTime $ocurredOn
    ) {
    }

    final public static function fromPrimitives(string $name, array $payload): DomainEvent
    {
        return new DomainEvent(
            DomainEventId::random(),
            new DomainEventName($name),
            new DomainEventPayload($payload),
            new \DateTime()
        );
    }

    public function toPrimitives(): array
    {
        return [
            'id'        => $this->id->value,
            'name'      => $this->name->value,
            'body'      => $this->payload->value,
            'ocurredOn' => $this->ocurredOn,
        ];
    }
}
