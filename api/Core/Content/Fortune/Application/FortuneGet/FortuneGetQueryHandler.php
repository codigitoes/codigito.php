<?php

declare(strict_types=1);

namespace Core\\Content\Fortune\Application\FortuneGet;

use Core\\Shared\Domain\Query\Query;
use Core\\Shared\Domain\Query\QueryHandler;
use Core\\Content\Fortune\Domain\Repository\FortuneReader;
use Core\\Content\Fortune\Domain\Model\FortuneGetReadModel;

class FortuneGetQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly FortuneReader $reader
    ) {
    }

    public function execute(Query $query): FortuneGetReadModel
    {
        return $this->reader->rand();
    }
}
