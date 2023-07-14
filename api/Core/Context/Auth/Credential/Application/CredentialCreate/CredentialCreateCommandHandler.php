<?php

declare(strict_types=1);

namespace Core\Context\Auth\Credential\Application\CredentialCreate;

use Core\Context\Auth\Credential\Domain\Model\Credential;
use Core\Context\Auth\Credential\Domain\Repository\CredentialWriter;
use Core\Context\Auth\Credential\Domain\ValueObject\CredentialEmail;
use Core\Context\Auth\Credential\Domain\ValueObject\CredentialId;
use Core\Context\Auth\Credential\Domain\ValueObject\CredentialPassword;
use Core\Context\Auth\Credential\Domain\ValueObject\CredentialRoles;
use Core\Context\Shared\Domain\Command\Command;
use Core\Context\Shared\Domain\Command\CommandHandler;

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
