<?php

declare(strict_types=1);

namespace Core\Content\Blogpost\Application\BlogpostLatest;

use Core\Shared\Domain\Filter\Page;
use Core\Shared\Domain\Query\Query;
use Core\Shared\Domain\Query\QueryHandler;
use Core\Content\Blogpost\Domain\Repository\BlogpostReader;
use Core\Content\Blogpost\Domain\Criteria\BlogpostSearchCriteria;
use Core\Content\Blogpost\Domain\Model\BlogpostCollectionReadModel;

class BlogpostLatestQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly BlogpostReader $reader
    ) {
    }

    public function execute(Query $query): BlogpostCollectionReadModel
    {
        $criteria = new BlogpostSearchCriteria(
            null,
            Page::FIRST_PAGE,
            $query->limit
        );

        return $this->reader->search($criteria);
    }
}
