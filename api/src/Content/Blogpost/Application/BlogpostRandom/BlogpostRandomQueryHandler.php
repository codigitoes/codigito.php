<?php

declare(strict_types=1);

namespace Codigito\Content\Blogpost\Application\BlogpostRandom;

use Codigito\Shared\Domain\Query\Query;
use Codigito\Shared\Domain\Query\QueryHandler;
use Codigito\Content\Blogpost\Domain\Repository\BlogpostReader;
use Codigito\Content\Blogpost\Domain\Model\BlogpostCollectionReadModel;

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
