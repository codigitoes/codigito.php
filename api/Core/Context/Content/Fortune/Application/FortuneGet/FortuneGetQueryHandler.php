<?php

declare(strict_types=1);

namespace Core\Context\Content\Fortune\Application\FortuneGet;

use Core\Context\Shared\Domain\Query\Query;
use Core\Context\Shared\Domain\Query\QueryHandler;
use Core\Context\Content\Fortune\Domain\Repository\FortuneReader;
use Core\Context\Content\Fortune\Domain\Model\FortuneGetReadModel;

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
