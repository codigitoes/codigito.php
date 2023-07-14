<?php

declare(strict_types=1);

namespace Core\Context\Fidelization\Mailing\Application\MailingCreate;

use Core\Context\Shared\Domain\Command\Command;

class MailingCreateCommand implements Command
{
    public function __construct(
        public readonly string $id,
        public readonly string $email
    ) {
    }
}
