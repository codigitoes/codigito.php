<?php

declare(strict_types=1);

namespace Codigito\Auth\Credential\Application\CredentialCreate;

use Codigito\Auth\Credential\Domain\Model\Credential;
use Codigito\Auth\Credential\Domain\Repository\CredentialWriter;
use Codigito\Auth\Credential\Domain\ValueObject\CredentialEmail;
use Codigito\Auth\Credential\Domain\ValueObject\CredentialId;
use Codigito\Auth\Credential\Domain\ValueObject\CredentialPassword;
use Codigito\Auth\Credential\Domain\ValueObject\CredentialRoles;
use Codigito\Shared\Domain\Command\Command;
use Codigito\Shared\Domain\Command\CommandHandler;

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
