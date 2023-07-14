<?php

declare(strict_types=1);

namespace Core\Fidelization\Mailing\Application\MailingConfirm;

use Core\Shared\Domain\Command\Command;

class MailingConfirmCommand implements Command
{
    public function __construct(
        public readonly string $id
    ) {
    }
}
