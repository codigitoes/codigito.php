<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Blogcontent\Application\BlogcontentGet;

use Codigoce\Context\Shared\Domain\Query\Query;
use Codigoce\Context\Shared\Domain\Query\QueryHandler;
use Codigoce\Context\Content\Blogcontent\Domain\Repository\BlogcontentReader;
use Codigoce\Context\Content\Blogcontent\Domain\Model\BlogcontentGetReadModel;
use Codigoce\Context\Content\Blogcontent\Domain\Criteria\BlogcontentGetByIdCriteria;

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
