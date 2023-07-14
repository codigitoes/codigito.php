<?php

declare(strict_types=1);

namespace Core\Context\Shared\Domain\Query;

use Core\Context\Shared\Domain\Model\ReadModel;

interface QueryHandler
{
    public function execute(Query $query): ReadModel;
}
