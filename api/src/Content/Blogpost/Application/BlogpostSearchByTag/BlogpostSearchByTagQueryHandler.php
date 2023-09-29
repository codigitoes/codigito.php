<?php

declare(strict_types=1);

namespace Codigito\Content\Blogpost\Application\BlogpostSearchByTag;

use Codigito\Content\Blogpost\Domain\Criteria\BlogpostSearchByTagCriteria;
use Codigito\Content\Blogpost\Domain\Model\BlogpostCollectionReadModel;
use Codigito\Content\Blogpost\Domain\Repository\BlogpostReader;
use Codigito\Shared\Domain\Query\Query;
use Codigito\Shared\Domain\Query\QueryHandler;

class BlogpostSearchByTagQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly BlogpostReader $reader
    ) {
    }

    public function execute(Query $query): BlogpostCollectionReadModel
    {
        $criteria = new BlogpostSearchByTagCriteria(
            $query->tag
        );

        return $this->reader->search($criteria);
    }
}
