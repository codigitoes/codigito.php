<?php

declare(strict_types=1);

namespace Codigoce\Context\Fidelization\Mailing\Application\MailingCreate;

use Codigoce\Context\Shared\Domain\Command\Command;
use Codigoce\Context\Shared\Domain\Command\CommandHandler;
use Codigoce\Context\Fidelization\Mailing\Domain\Model\Mailing;
use Codigoce\Context\Fidelization\Mailing\Domain\ValueObject\MailingId;
use Codigoce\Context\Fidelization\Mailing\Domain\Repository\MailingWriter;
use Codigoce\Context\Fidelization\Mailing\Domain\ValueObject\MailingEmail;

class MailingCreateCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly MailingWriter $writer,
    ) {
    }

    public function execute(Command $command): void
    {
        $this->writer->create(Mailing::createForNew(
            new MailingId($command->id),
            new MailingEmail($command->email)
        ));
    }
}
