<?php

declare(strict_types=1);

namespace Codigito\Fidelization\Mailing\Application\MailingCreate;

use Codigito\Shared\Domain\Command\Command;
use Codigito\Shared\Domain\Event\DomainEventBus;
use Codigito\Shared\Domain\Command\CommandHandler;
use Codigito\Fidelization\Mailing\Domain\Model\Mailing;
use Codigito\Fidelization\Mailing\Domain\ValueObject\MailingId;
use Codigito\Fidelization\Mailing\Domain\Repository\MailingWriter;
use Codigito\Fidelization\Mailing\Domain\ValueObject\MailingEmail;

class MailingCreateCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly DomainEventBus $eventor,
        private readonly MailingWriter $writer,
    ) {
    }

    public function execute(Command $command): void
    {
        $mailing = Mailing::createForNew(
            new MailingId($command->id),
            new MailingEmail($command->email)
        );

        $this->writer->create($mailing);

        $this->eventor->publish($mailing->pullEvents());
    }
}
