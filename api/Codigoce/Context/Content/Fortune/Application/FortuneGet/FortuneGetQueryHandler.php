<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Fortune\Application\FortuneGet;

use Codigoce\Context\Shared\Domain\Query\Query;
use Codigoce\Context\Shared\Domain\Query\QueryHandler;
use Codigoce\Context\Content\Fortune\Domain\Repository\FortuneReader;
use Codigoce\Context\Content\Fortune\Domain\Model\FortuneGetReadModel;

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