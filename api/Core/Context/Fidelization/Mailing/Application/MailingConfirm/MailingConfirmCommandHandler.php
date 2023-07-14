<?php

declare(strict_types=1);

namespace Core\Context\Fidelization\Mailing\Application\MailingConfirm;

use Core\Context\Shared\Domain\Command\Command;
use Core\Context\Shared\Domain\Command\CommandHandler;
use Core\Context\Fidelization\Mailing\Domain\Repository\MailingReader;
use Core\Context\Fidelization\Mailing\Domain\Repository\MailingWriter;
use Core\Context\Fidelization\Mailing\Domain\Criteria\MailingGetByIdCriteria;

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
