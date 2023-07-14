<?php

declare(strict_types=1);

namespace Core\Context\Content\Blogcontent\Application\BlogcontentSearch;

use Core\Context\Shared\Domain\Query\Query;
use Core\Context\Shared\Domain\Query\QueryHandler;
use Core\Context\Content\Blogcontent\Domain\Repository\BlogcontentReader;
use Core\Context\Content\Blogcontent\Domain\Criteria\BlogcontentSearchCriteria;
use Core\Context\Content\Blogcontent\Domain\Model\BlogcontentCollectionReadModel;

class BlogcontentSearchQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly BlogcontentReader $reader
    ) {
    }

    public function execute(Query $query): BlogcontentCollectionReadModel
    {
        $criteria = new BlogcontentSearchCriteria(
            $query->blogpostId,
            $query->pattern,
            $query->page,
            $query->limit
        );

        return $this->reader->search($criteria);
    }
}
