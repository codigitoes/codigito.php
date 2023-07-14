<?php

declare(strict_types=1);

namespace Core\\Content\Blogpost\Application\BlogpostSearch;

use Core\\Content\Blogpost\Domain\Criteria\BlogpostSearchCriteria;
use Core\\Content\Blogpost\Domain\Model\BlogpostCollectionReadModel;
use Core\\Content\Blogpost\Domain\Repository\BlogpostReader;
use Core\\Shared\Domain\Query\Query;
use Core\\Shared\Domain\Query\QueryHandler;

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
