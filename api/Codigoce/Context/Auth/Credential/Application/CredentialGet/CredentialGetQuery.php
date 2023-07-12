<?php

declare(strict_types=1);

namespace Codigoce\Context\Auth\Credential\Application\CredentialGet;

use Codigoce\Context\Shared\Domain\Query\Query;

class CredentialGetQuery implements Query
{
    public function __construct(
        public readonly string $id
    ) {
    }
}
