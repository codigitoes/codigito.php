<?php

declare(strict_types=1);

namespace Core\Content\Blogpost\Application\BlogpostRandom;

use Core\Shared\Domain\Query\Query;
use Core\Shared\Domain\Query\QueryHandler;
use Core\Content\Blogpost\Domain\Repository\BlogpostReader;
use Core\Content\Blogpost\Domain\Model\BlogpostCollectionReadModel;

class BlogpostRandomQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly BlogpostReader $reader
    ) {
    }

    public function execute(Query $query): BlogpostCollectionReadModel
    {
        return $this->reader->random($query->limit);
    }
}
