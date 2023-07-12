<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Blogpost\Application\BlogpostRandom;

use Codigoce\Context\Shared\Domain\Query\Query;
use Codigoce\Context\Shared\Domain\Query\QueryHandler;
use Codigoce\Context\Content\Blogpost\Domain\Repository\BlogpostReader;
use Codigoce\Context\Content\Blogpost\Domain\Model\BlogpostCollectionReadModel;

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
