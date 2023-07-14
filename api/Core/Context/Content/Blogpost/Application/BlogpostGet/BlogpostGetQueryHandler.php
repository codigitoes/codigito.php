<?php

declare(strict_types=1);

namespace Core\Context\Content\Blogpost\Application\BlogpostGet;

use Core\Context\Content\Blogpost\Domain\Criteria\BlogpostGetByIdCriteria;
use Core\Context\Content\Blogpost\Domain\Model\BlogpostGetReadModel;
use Core\Context\Content\Blogpost\Domain\Repository\BlogpostReader;
use Core\Context\Shared\Domain\Query\Query;
use Core\Context\Shared\Domain\Query\QueryHandler;

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
