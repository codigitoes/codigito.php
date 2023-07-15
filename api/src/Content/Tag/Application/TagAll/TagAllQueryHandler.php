<?php

declare(strict_types=1);

namespace Codigito\Content\Tag\Application\TagAll;

use Codigito\Shared\Domain\Filter\Page;
use Codigito\Shared\Domain\Query\Query;
use Codigito\Shared\Domain\Query\QueryHandler;
use Codigito\Content\Tag\Domain\Repository\TagReader;
use Codigito\Content\Tag\Domain\Criteria\TagSearchCriteria;
use Codigito\Content\Tag\Domain\Model\TagCollectionReadModel;

class TagAllQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly TagReader $reader
    ) {
    }

    public function execute(Query $query): TagCollectionReadModel
    {
        $criteria = new TagSearchCriteria(
            null,
            Page::FIRST_PAGE,
            100
        );

        return $this->reader->search($criteria);
    }
}
