<?php

declare(strict_types=1);

namespace Core\\Fidelization\Mailing\Application\MailingCreate;

use Core\\Shared\Domain\Command\Command;
use Core\\Shared\Domain\Command\CommandHandler;
use Core\\Fidelization\Mailing\Domain\Model\Mailing;
use Core\\Fidelization\Mailing\Domain\ValueObject\MailingId;
use Core\\Fidelization\Mailing\Domain\Repository\MailingWriter;
use Core\\Fidelization\Mailing\Domain\ValueObject\MailingEmail;

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
