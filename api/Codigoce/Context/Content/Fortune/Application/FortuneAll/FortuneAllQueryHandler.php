<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Fortune\Application\FortuneAll;

use Codigoce\Context\Shared\Domain\Query\Query;
use Codigoce\Context\Shared\Domain\Query\QueryHandler;
use Codigoce\Context\Content\Fortune\Domain\Repository\FortuneReader;
use Codigoce\Context\Content\Fortune\Domain\Model\FortuneCollectionReadModel;

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
