<?php

declare(strict_types=1);

namespace Codigito\Fidelization\Mailing\Application\MailingSendEmail;

use Codigito\Fidelization\Mailing\Domain\Exception\MailingCantSendEmailException;
use Codigito\Shared\Domain\Command\Command;
use Codigito\Shared\Domain\Command\CommandHandler;
use Codigito\Shared\Domain\Service\MailerSender;

class MailingSendEmailCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly MailerSender $mailer
    ) {
    }

    public function execute(Command $command): void
    {
        try {
            $this->mailer->send($command->from, $command->to, $command->subject, $command->html);
        } catch (\Throwable) {
            throw new MailingCantSendEmailException(json_encode($command));
        }
    }
}
