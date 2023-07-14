<?php

declare(strict_types=1);

namespace Core\\Content\Fortune\Application\FortuneAll;

use Core\\Shared\Domain\Query\Query;
use Core\\Shared\Domain\Query\QueryHandler;
use Core\\Content\Fortune\Domain\Repository\FortuneReader;
use Core\\Content\Fortune\Domain\Model\FortuneCollectionReadModel;

class FortuneAllQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly FortuneReader $reader
    ) {
    }

    public function execute(Query $query): FortuneCollectionReadModel
    {
        return $this->reader->all();
    }
}
