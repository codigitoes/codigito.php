<?php

declare(strict_types=1);

namespace Codigito\Fidelization\Mailing\Application\MailingSendEmail;

use Codigito\Shared\Domain\Command\Command;

class MailingSendEmailCommand implements Command
{
    public function __construct(
        public readonly string $from,
        public readonly string $to,
        public readonly string $subject,
        public readonly string $html
    ) {
    }
}
