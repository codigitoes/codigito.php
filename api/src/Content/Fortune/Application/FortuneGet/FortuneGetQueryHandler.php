<?php

declare(strict_types=1);

namespace Codigito\Content\Fortune\Application\FortuneGet;

use Codigito\Shared\Domain\Query\Query;
use Codigito\Shared\Domain\Query\QueryHandler;
use Codigito\Content\Fortune\Domain\Repository\FortuneReader;
use Codigito\Content\Fortune\Domain\Model\FortuneGetReadModel;

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
