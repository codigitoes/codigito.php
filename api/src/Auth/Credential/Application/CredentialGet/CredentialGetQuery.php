<?php

declare(strict_types=1);

namespace Codigito\Auth\Credential\Application\CredentialGet;

use Codigito\Shared\Domain\Query\Query;

class CredentialGetQuery implements Query
{
    public function __construct(
        public readonly string $id
    ) {
    }
}
