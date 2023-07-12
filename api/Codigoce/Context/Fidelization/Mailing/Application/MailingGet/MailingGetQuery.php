<?php

declare(strict_types=1);

namespace Codigoce\Context\Fidelization\Mailing\Application\MailingGet;

use Codigoce\Context\Shared\Domain\Query\Query;

class MailingGetQuery implements Query
{
    public function __construct(
        public readonly string $id
    ) {
    }
}
