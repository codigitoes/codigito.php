<?php

declare(strict_types=1);

namespace Core\Context\Content\Fortune\Application\FortuneAll;

use Core\Context\Shared\Domain\Query\Query;
use Core\Context\Shared\Domain\Query\QueryHandler;
use Core\Context\Content\Fortune\Domain\Repository\FortuneReader;
use Core\Context\Content\Fortune\Domain\Model\FortuneCollectionReadModel;

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
