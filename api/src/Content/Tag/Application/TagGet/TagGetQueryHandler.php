<?php

declare(strict_types=1);

namespace Codigito\Content\Tag\Application\TagGet;

use Codigito\Content\Tag\Domain\Criteria\TagGetByIdCriteria;
use Codigito\Content\Tag\Domain\Model\TagGetReadModel;
use Codigito\Content\Tag\Domain\Repository\TagReader;
use Codigito\Shared\Domain\Query\Query;
use Codigito\Shared\Domain\Query\QueryHandler;

class TagGetQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly TagReader $reader
    ) {
    }

    public function execute(Query $query): TagGetReadModel
    {
        $criteria = new TagGetByIdCriteria($query->id);

        return $this->reader->getTagByCriteria($criteria);
    }
}
