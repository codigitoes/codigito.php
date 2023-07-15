<?php

declare(strict_types=1);

namespace Codigito\Shared\Domain\Query;

use Codigito\Shared\Domain\Model\ReadModel;

interface QueryHandler
{
    public function execute(Query $query): ReadModel;
}
