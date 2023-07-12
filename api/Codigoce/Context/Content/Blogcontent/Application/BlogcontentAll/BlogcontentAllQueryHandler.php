<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Blogcontent\Application\BlogcontentAll;

use Codigoce\Context\Shared\Domain\Filter\Page;
use Codigoce\Context\Shared\Domain\Query\Query;
use Codigoce\Context\Shared\Domain\Query\QueryHandler;
use Codigoce\Context\Content\Blogcontent\Domain\Repository\BlogcontentReader;
use Codigoce\Context\Content\Blogcontent\Domain\Criteria\BlogcontentSearchCriteria;
use Codigoce\Context\Content\Blogcontent\Domain\Model\BlogcontentCollectionReadModel;

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
