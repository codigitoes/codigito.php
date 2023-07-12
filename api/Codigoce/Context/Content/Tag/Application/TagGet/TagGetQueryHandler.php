<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Tag\Application\TagGet;

use Codigoce\Context\Content\Tag\Domain\Criteria\TagGetByIdCriteria;
use Codigoce\Context\Content\Tag\Domain\Model\TagGetReadModel;
use Codigoce\Context\Content\Tag\Domain\Repository\TagReader;
use Codigoce\Context\Shared\Domain\Query\Query;
use Codigoce\Context\Shared\Domain\Query\QueryHandler;

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
