<?php

declare(strict_types=1);

namespace Core\Content\Tag\Application\TagSearch;

use Core\Content\Tag\Domain\Criteria\TagSearchCriteria;
use Core\Content\Tag\Domain\Model\TagCollectionReadModel;
use Core\Content\Tag\Domain\Repository\TagReader;
use Core\Shared\Domain\Query\Query;
use Core\Shared\Domain\Query\QueryHandler;

class TagSearchQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly TagReader $reader
    ) {
    }

    public function execute(Query $query): TagCollectionReadModel
    {
        $criteria = new TagSearchCriteria(
            $query->pattern,
            $query->page,
            $query->limit
        );

        return $this->reader->search($criteria);
    }
}
