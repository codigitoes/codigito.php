<?php

declare(strict_types=1);

namespace Core\Context\Auth\Credential\Application\CredentialGet;

use Core\Context\Shared\Domain\Query\Query;

class CredentialGetQuery implements Query
{
    public function __construct(
        public readonly string $id
    ) {
    }
}
