<?php

declare(strict_types=1);

namespace Core\Context\Content\Blogpost\Application\BlogpostSearch;

use Core\Context\Content\Blogpost\Domain\Criteria\BlogpostSearchCriteria;
use Core\Context\Content\Blogpost\Domain\Model\BlogpostCollectionReadModel;
use Core\Context\Content\Blogpost\Domain\Repository\BlogpostReader;
use Core\Context\Shared\Domain\Query\Query;
use Core\Context\Shared\Domain\Query\QueryHandler;

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
