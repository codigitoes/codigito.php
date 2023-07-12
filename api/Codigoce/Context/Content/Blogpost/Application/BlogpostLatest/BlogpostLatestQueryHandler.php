<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Blogpost\Application\BlogpostLatest;

use Codigoce\Context\Shared\Domain\Filter\Page;
use Codigoce\Context\Shared\Domain\Query\Query;
use Codigoce\Context\Shared\Domain\Query\QueryHandler;
use Codigoce\Context\Content\Blogpost\Domain\Repository\BlogpostReader;
use Codigoce\Context\Content\Blogpost\Domain\Criteria\BlogpostSearchCriteria;
use Codigoce\Context\Content\Blogpost\Domain\Model\BlogpostCollectionReadModel;

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
