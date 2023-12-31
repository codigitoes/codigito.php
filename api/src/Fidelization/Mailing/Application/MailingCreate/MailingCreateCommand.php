<?php

declare(strict_types=1);

namespace Codigito\Fidelization\Mailing\Application\MailingCreate;

use Codigito\Shared\Domain\Command\Command;

class MailingCreateCommand implements Command
{
    public function __construct(
        public readonly string $id,
        public readonly string $email
    ) {
    }
}
