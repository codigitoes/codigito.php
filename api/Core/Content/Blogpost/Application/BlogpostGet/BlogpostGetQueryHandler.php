<?php

declare(strict_types=1);

namespace Core\Content\Blogpost\Application\BlogpostGet;

use Core\Content\Blogpost\Domain\Criteria\BlogpostGetByIdCriteria;
use Core\Content\Blogpost\Domain\Model\BlogpostGetReadModel;
use Core\Content\Blogpost\Domain\Repository\BlogpostReader;
use Core\Shared\Domain\Query\Query;
use Core\Shared\Domain\Query\QueryHandler;

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
