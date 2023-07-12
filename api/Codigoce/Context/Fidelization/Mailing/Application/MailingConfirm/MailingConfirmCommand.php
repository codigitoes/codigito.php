<?php

declare(strict_types=1);

namespace Codigoce\Context\Fidelization\Mailing\Application\MailingConfirm;

use Codigoce\Context\Shared\Domain\Command\Command;

class MailingConfirmCommand implements Command
{
    public function __construct(
        public readonly string $id
    ) {
    }
}
