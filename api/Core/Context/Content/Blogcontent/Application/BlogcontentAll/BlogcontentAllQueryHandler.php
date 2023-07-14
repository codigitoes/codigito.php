<?php

declare(strict_types=1);

namespace Core\Context\Content\Blogcontent\Application\BlogcontentAll;

use Core\Context\Shared\Domain\Filter\Page;
use Core\Context\Shared\Domain\Query\Query;
use Core\Context\Shared\Domain\Query\QueryHandler;
use Core\Context\Content\Blogcontent\Domain\Repository\BlogcontentReader;
use Core\Context\Content\Blogcontent\Domain\Criteria\BlogcontentSearchCriteria;
use Core\Context\Content\Blogcontent\Domain\Model\BlogcontentCollectionReadModel;

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
