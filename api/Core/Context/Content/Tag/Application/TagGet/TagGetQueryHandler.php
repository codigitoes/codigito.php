<?php

declare(strict_types=1);

namespace Core\Context\Content\Tag\Application\TagGet;

use Core\Context\Content\Tag\Domain\Criteria\TagGetByIdCriteria;
use Core\Context\Content\Tag\Domain\Model\TagGetReadModel;
use Core\Context\Content\Tag\Domain\Repository\TagReader;
use Core\Context\Shared\Domain\Query\Query;
use Core\Context\Shared\Domain\Query\QueryHandler;

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
