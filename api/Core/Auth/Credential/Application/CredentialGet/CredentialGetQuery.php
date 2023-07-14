<?php

declare(strict_types=1);

namespace Core\\Auth\Credential\Application\CredentialGet;

use Core\\Shared\Domain\Query\Query;

class CredentialGetQuery implements Query
{
    public function __construct(
        public readonly string $id
    ) {
    }
}
