<?php

declare(strict_types=1);

namespace Core\\Auth\Credential\Application\CredentialCreate;

use Core\\Shared\Domain\Command\Command;

class CredentialCreateCommand implements Command
{
    public function __construct(
        public readonly string $id,
        public readonly string $email,
        public readonly string $password,
        public readonly array $roles
    ) {
    }
}
