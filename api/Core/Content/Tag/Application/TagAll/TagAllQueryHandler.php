<?php

declare(strict_types=1);

namespace Core\Content\Tag\Application\TagAll;

use Core\Shared\Domain\Filter\Page;
use Core\Shared\Domain\Query\Query;
use Core\Shared\Domain\Query\QueryHandler;
use Core\Content\Tag\Domain\Repository\TagReader;
use Core\Content\Tag\Domain\Criteria\TagSearchCriteria;
use Core\Content\Tag\Domain\Model\TagCollectionReadModel;

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
