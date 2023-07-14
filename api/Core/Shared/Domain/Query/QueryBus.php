<?php

declare(strict_types=1);

namespace Core\\Shared\Domain\Query;

use Core\\Shared\Domain\Model\ReadModel;

interface QueryBus
{
    public function execute(Query $query): ReadModel;
}
