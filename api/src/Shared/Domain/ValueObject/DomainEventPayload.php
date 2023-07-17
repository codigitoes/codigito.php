<?php

declare(strict_types=1);

namespace Codigito\Shared\Domain\ValueObject;

use Codigito\Shared\Domain\Exception\InvalidParameterException;

class DomainEventPayload
{
    public function __construct(public readonly array $value)
    {
        if (empty($value)) {
            throw new InvalidParameterException('wrong payload: '.json_encode($value));
        }
    }
}
