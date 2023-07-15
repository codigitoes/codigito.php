<?php

declare(strict_types=1);

namespace Codigito\Content\Blogpost\Application\BlogpostGet;

use Codigito\Content\Blogpost\Domain\Criteria\BlogpostGetByIdCriteria;
use Codigito\Content\Blogpost\Domain\Model\BlogpostGetReadModel;
use Codigito\Content\Blogpost\Domain\Repository\BlogpostReader;
use Codigito\Shared\Domain\Query\Query;
use Codigito\Shared\Domain\Query\QueryHandler;

class BlogpostGetQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly BlogpostReader $reader
    ) {
    }

    public function execute(Query $query): BlogpostGetReadModel
    {
        $criteria = new BlogpostGetByIdCriteria($query->id);

        return $this->reader->getBlogpostByCriteria($criteria);
    }
}
