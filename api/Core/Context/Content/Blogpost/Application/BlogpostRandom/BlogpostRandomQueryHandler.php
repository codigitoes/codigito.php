<?php

declare(strict_types=1);

namespace Core\Context\Content\Blogpost\Application\BlogpostRandom;

use Core\Context\Shared\Domain\Query\Query;
use Core\Context\Shared\Domain\Query\QueryHandler;
use Core\Context\Content\Blogpost\Domain\Repository\BlogpostReader;
use Core\Context\Content\Blogpost\Domain\Model\BlogpostCollectionReadModel;

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
