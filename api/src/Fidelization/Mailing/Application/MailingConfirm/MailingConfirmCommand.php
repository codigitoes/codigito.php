<?php

declare(strict_types=1);

namespace Codigito\Fidelization\Mailing\Application\MailingConfirm;

use Codigito\Shared\Domain\Command\Command;

class MailingConfirmCommand implements Command
{
    public function __construct(
        public readonly string $id
    ) {
    }
}
