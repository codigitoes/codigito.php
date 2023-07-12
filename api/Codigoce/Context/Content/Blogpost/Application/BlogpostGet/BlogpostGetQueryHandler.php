<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Blogpost\Application\BlogpostGet;

use Codigoce\Context\Content\Blogpost\Domain\Criteria\BlogpostGetByIdCriteria;
use Codigoce\Context\Content\Blogpost\Domain\Model\BlogpostGetReadModel;
use Codigoce\Context\Content\Blogpost\Domain\Repository\BlogpostReader;
use Codigoce\Context\Shared\Domain\Query\Query;
use Codigoce\Context\Shared\Domain\Query\QueryHandler;

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
