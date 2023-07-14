<?php

declare(strict_types=1);

namespace Core\Auth\Credential\Application\CredentialCreate;

use Core\Auth\Credential\Domain\Model\Credential;
use Core\Auth\Credential\Domain\Repository\CredentialWriter;
use Core\Auth\Credential\Domain\ValueObject\CredentialEmail;
use Core\Auth\Credential\Domain\ValueObject\CredentialId;
use Core\Auth\Credential\Domain\ValueObject\CredentialPassword;
use Core\Auth\Credential\Domain\ValueObject\CredentialRoles;
use Core\Shared\Domain\Command\Command;
use Core\Shared\Domain\Command\CommandHandler;

class CredentialCreateCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly CredentialWriter $writer
    ) {
    }

    public function execute(Command $command): void
    {
        $this->writer->create(
            Credential::createNew(
                new CredentialId($command->id),
                new CredentialEmail($command->email),
                new CredentialPassword($command->password),
                new CredentialRoles($command->roles)
            )
        );
    }
}
