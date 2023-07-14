<?php

declare(strict_types=1);

namespace Core\Context\Content\Tag\Application\TagSearch;

use Core\Context\Content\Tag\Domain\Criteria\TagSearchCriteria;
use Core\Context\Content\Tag\Domain\Model\TagCollectionReadModel;
use Core\Context\Content\Tag\Domain\Repository\TagReader;
use Core\Context\Shared\Domain\Query\Query;
use Core\Context\Shared\Domain\Query\QueryHandler;

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
