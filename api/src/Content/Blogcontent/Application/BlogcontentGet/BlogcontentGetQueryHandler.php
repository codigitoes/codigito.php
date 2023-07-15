<?php

declare(strict_types=1);

namespace Codigito\Content\Blogcontent\Application\BlogcontentGet;

use Codigito\Shared\Domain\Query\Query;
use Codigito\Shared\Domain\Query\QueryHandler;
use Codigito\Content\Blogcontent\Domain\Repository\BlogcontentReader;
use Codigito\Content\Blogcontent\Domain\Model\BlogcontentGetReadModel;
use Codigito\Content\Blogcontent\Domain\Criteria\BlogcontentGetByIdCriteria;

class BlogcontentGetQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly BlogcontentReader $reader
    ) {
    }

    public function execute(Query $query): BlogcontentGetReadModel
    {
        $criteria = new BlogcontentGetByIdCriteria(
            $query->blogpostId,
            $query->id
        );

        return $this->reader->getBlogcontentByCriteria($criteria);
    }
}
