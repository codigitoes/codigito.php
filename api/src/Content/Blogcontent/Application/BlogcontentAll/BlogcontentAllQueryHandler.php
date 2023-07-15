<?php

declare(strict_types=1);

namespace Codigito\Content\Blogcontent\Application\BlogcontentAll;

use Codigito\Shared\Domain\Filter\Page;
use Codigito\Shared\Domain\Query\Query;
use Codigito\Shared\Domain\Query\QueryHandler;
use Codigito\Content\Blogcontent\Domain\Repository\BlogcontentReader;
use Codigito\Content\Blogcontent\Domain\Criteria\BlogcontentSearchCriteria;
use Codigito\Content\Blogcontent\Domain\Model\BlogcontentCollectionReadModel;

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
