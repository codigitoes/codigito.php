<?php

declare(strict_types=1);

namespace Codigoce\Context\Auth\Credential\Application\CredentialCreate;

use Codigoce\Context\Auth\Credential\Domain\Model\Credential;
use Codigoce\Context\Auth\Credential\Domain\Repository\CredentialWriter;
use Codigoce\Context\Auth\Credential\Domain\ValueObject\CredentialEmail;
use Codigoce\Context\Auth\Credential\Domain\ValueObject\CredentialId;
use Codigoce\Context\Auth\Credential\Domain\ValueObject\CredentialPassword;
use Codigoce\Context\Auth\Credential\Domain\ValueObject\CredentialRoles;
use Codigoce\Context\Shared\Domain\Command\Command;
use Codigoce\Context\Shared\Domain\Command\CommandHandler;

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
