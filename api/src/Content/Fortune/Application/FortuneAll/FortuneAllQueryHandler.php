<?php

declare(strict_types=1);

namespace Codigito\Content\Fortune\Application\FortuneAll;

use Codigito\Shared\Domain\Query\Query;
use Codigito\Shared\Domain\Query\QueryHandler;
use Codigito\Content\Fortune\Domain\Repository\FortuneReader;
use Codigito\Content\Fortune\Domain\Model\FortuneCollectionReadModel;

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
