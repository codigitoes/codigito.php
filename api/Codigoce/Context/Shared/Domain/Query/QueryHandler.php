<?php

declare(strict_types=1);

namespace Codigoce\Context\Shared\Domain\Query;

use Codigoce\Context\Shared\Domain\Model\ReadModel;

interface QueryHandler
{
    public function execute(Query $query): ReadModel;
}
