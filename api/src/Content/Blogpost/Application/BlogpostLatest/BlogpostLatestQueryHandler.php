<?php

declare(strict_types=1);

namespace Codigito\Content\Blogpost\Application\BlogpostLatest;

use Codigito\Shared\Domain\Filter\Page;
use Codigito\Shared\Domain\Query\Query;
use Codigito\Shared\Domain\Query\QueryHandler;
use Codigito\Content\Blogpost\Domain\Repository\BlogpostReader;
use Codigito\Content\Blogpost\Domain\Criteria\BlogpostSearchCriteria;
use Codigito\Content\Blogpost\Domain\Model\BlogpostCollectionReadModel;

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
