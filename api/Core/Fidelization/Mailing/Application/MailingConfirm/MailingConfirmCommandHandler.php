<?php

declare(strict_types=1);

namespace Core\\Fidelization\Mailing\Application\MailingConfirm;

use Core\\Shared\Domain\Command\Command;
use Core\\Shared\Domain\Command\CommandHandler;
use Core\\Fidelization\Mailing\Domain\Repository\MailingReader;
use Core\\Fidelization\Mailing\Domain\Repository\MailingWriter;
use Core\\Fidelization\Mailing\Domain\Criteria\MailingGetByIdCriteria;

class MailingConfirmCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly MailingReader $reader,
        private readonly MailingWriter $writer
    ) {
    }

    public function execute(Command $command): void
    {
        $criteria = new MailingGetByIdCriteria($command->id);
        $mailing  = $this->reader->getMailingModelByCriteria($criteria);

        $mailing->confirm();

        $this->writer->update($mailing);
    }
}
