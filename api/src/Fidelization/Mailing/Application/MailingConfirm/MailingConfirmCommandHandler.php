<?php

declare(strict_types=1);

namespace Codigito\Fidelization\Mailing\Application\MailingConfirm;

use Codigito\Shared\Domain\Command\Command;
use Codigito\Shared\Domain\Event\DomainEventBus;
use Codigito\Shared\Domain\Command\CommandHandler;
use Codigito\Fidelization\Mailing\Domain\Repository\MailingReader;
use Codigito\Fidelization\Mailing\Domain\Repository\MailingWriter;
use Codigito\Fidelization\Mailing\Domain\Criteria\MailingGetByIdCriteria;

class MailingConfirmCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly MailingReader $reader,
        private readonly MailingWriter $writer,
        private readonly DomainEventBus $eventor
    ) {
    }

    public function execute(Command $command): void
    {
        $criteria = new MailingGetByIdCriteria($command->id);
        $mailing  = $this->reader->getMailingModelByCriteria($criteria);
        if ($mailing->isConfirmed()) {
            return;
        }

        $mailing->confirm();

        $this->writer->update($mailing);

        $this->eventor->publish($mailing->pullEvents());
    }
}
