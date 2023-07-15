<?php

declare(strict_types=1);

namespace Codigito\Content\Blogcontent\Application\BlogcontentSearch;

use Codigito\Shared\Domain\Query\Query;
use Codigito\Shared\Domain\Query\QueryHandler;
use Codigito\Content\Blogcontent\Domain\Repository\BlogcontentReader;
use Codigito\Content\Blogcontent\Domain\Criteria\BlogcontentSearchCriteria;
use Codigito\Content\Blogcontent\Domain\Model\BlogcontentCollectionReadModel;

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
