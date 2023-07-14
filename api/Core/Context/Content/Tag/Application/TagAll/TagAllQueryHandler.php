<?php

declare(strict_types=1);

namespace Core\Context\Content\Tag\Application\TagAll;

use Core\Context\Shared\Domain\Filter\Page;
use Core\Context\Shared\Domain\Query\Query;
use Core\Context\Shared\Domain\Query\QueryHandler;
use Core\Context\Content\Tag\Domain\Repository\TagReader;
use Core\Context\Content\Tag\Domain\Criteria\TagSearchCriteria;
use Core\Context\Content\Tag\Domain\Model\TagCollectionReadModel;

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
