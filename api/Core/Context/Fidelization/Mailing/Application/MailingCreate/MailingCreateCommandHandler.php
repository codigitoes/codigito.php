<?php

declare(strict_types=1);

namespace Core\Context\Fidelization\Mailing\Application\MailingCreate;

use Core\Context\Shared\Domain\Command\Command;
use Core\Context\Shared\Domain\Command\CommandHandler;
use Core\Context\Fidelization\Mailing\Domain\Model\Mailing;
use Core\Context\Fidelization\Mailing\Domain\ValueObject\MailingId;
use Core\Context\Fidelization\Mailing\Domain\Repository\MailingWriter;
use Core\Context\Fidelization\Mailing\Domain\ValueObject\MailingEmail;

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
