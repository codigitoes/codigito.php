<?php

declare(strict_types=1);

namespace Core\Content\Blogcontent\Application\BlogcontentAll;

use Core\Shared\Domain\Filter\Page;
use Core\Shared\Domain\Query\Query;
use Core\Shared\Domain\Query\QueryHandler;
use Core\Content\Blogcontent\Domain\Repository\BlogcontentReader;
use Core\Content\Blogcontent\Domain\Criteria\BlogcontentSearchCriteria;
use Core\Content\Blogcontent\Domain\Model\BlogcontentCollectionReadModel;

class BlogcontentAllQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly BlogcontentReader $reader
    ) {
    }

    public function execute(Query $query): BlogcontentCollectionReadModel
    {
        $criteria = new BlogcontentSearchCriteria(
            $query->blogpostId,
            null,
            Page::FIRST_PAGE,
            100
        );

        return $this->reader->search($criteria);
    }
}
