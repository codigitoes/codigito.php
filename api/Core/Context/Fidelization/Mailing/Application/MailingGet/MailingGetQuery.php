<?php

declare(strict_types=1);

namespace Core\Context\Fidelization\Mailing\Application\MailingGet;

use Core\Context\Shared\Domain\Query\Query;

class MailingGetQuery implements Query
{
    public function __construct(
        public readonly string $id
    ) {
    }
}
