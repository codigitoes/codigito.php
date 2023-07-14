<?php

declare(strict_types=1);

namespace Core\\Content\Tag\Application\TagGet;

use Core\\Content\Tag\Domain\Criteria\TagGetByIdCriteria;
use Core\\Content\Tag\Domain\Model\TagGetReadModel;
use Core\\Content\Tag\Domain\Repository\TagReader;
use Core\\Shared\Domain\Query\Query;
use Core\\Shared\Domain\Query\QueryHandler;

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
