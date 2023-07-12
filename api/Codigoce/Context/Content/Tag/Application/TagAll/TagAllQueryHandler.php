<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Tag\Application\TagAll;

use Codigoce\Context\Shared\Domain\Filter\Page;
use Codigoce\Context\Shared\Domain\Query\Query;
use Codigoce\Context\Shared\Domain\Query\QueryHandler;
use Codigoce\Context\Content\Tag\Domain\Repository\TagReader;
use Codigoce\Context\Content\Tag\Domain\Criteria\TagSearchCriteria;
use Codigoce\Context\Content\Tag\Domain\Model\TagCollectionReadModel;

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
