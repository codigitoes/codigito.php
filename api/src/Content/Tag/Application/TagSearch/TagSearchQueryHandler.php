<?php

declare(strict_types=1);

namespace Codigito\Content\Tag\Application\TagSearch;

use Codigito\Content\Tag\Domain\Criteria\TagSearchCriteria;
use Codigito\Content\Tag\Domain\Model\TagCollectionReadModel;
use Codigito\Content\Tag\Domain\Repository\TagReader;
use Codigito\Shared\Domain\Query\Query;
use Codigito\Shared\Domain\Query\QueryHandler;

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
