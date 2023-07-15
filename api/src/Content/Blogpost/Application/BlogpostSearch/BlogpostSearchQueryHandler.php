<?php

declare(strict_types=1);

namespace Codigito\Content\Blogpost\Application\BlogpostSearch;

use Codigito\Content\Blogpost\Domain\Criteria\BlogpostSearchCriteria;
use Codigito\Content\Blogpost\Domain\Model\BlogpostCollectionReadModel;
use Codigito\Content\Blogpost\Domain\Repository\BlogpostReader;
use Codigito\Shared\Domain\Query\Query;
use Codigito\Shared\Domain\Query\QueryHandler;

class BlogpostSearchQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly BlogpostReader $reader
    ) {
    }

    public function execute(Query $query): BlogpostCollectionReadModel
    {
        $criteria = new BlogpostSearchCriteria(
            $query->pattern,
            $query->page,
            $query->limit
        );

        return $this->reader->search($criteria);
    }
}
