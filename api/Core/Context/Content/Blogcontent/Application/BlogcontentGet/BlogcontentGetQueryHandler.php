<?php

declare(strict_types=1);

namespace Core\Context\Content\Blogcontent\Application\BlogcontentGet;

use Core\Context\Shared\Domain\Query\Query;
use Core\Context\Shared\Domain\Query\QueryHandler;
use Core\Context\Content\Blogcontent\Domain\Repository\BlogcontentReader;
use Core\Context\Content\Blogcontent\Domain\Model\BlogcontentGetReadModel;
use Core\Context\Content\Blogcontent\Domain\Criteria\BlogcontentGetByIdCriteria;

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
