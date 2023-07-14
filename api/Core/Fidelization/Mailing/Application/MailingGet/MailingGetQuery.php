<?php

declare(strict_types=1);

namespace Core\\Fidelization\Mailing\Application\MailingGet;

use Core\\Shared\Domain\Query\Query;

class MailingGetQuery implements Query
{
    public function __construct(
        public readonly string $id
    ) {
    }
}
