<?php

declare(strict_types=1);

namespace Codigito\Fidelization\Mailing\Application\MailingGet;

use Codigito\Shared\Domain\Query\Query;

class MailingGetQuery implements Query
{
    public function __construct(
        public readonly string $id
    ) {
    }
}
