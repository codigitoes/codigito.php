<?php

declare(strict_types=1);

namespace Codigito\Content\Tag\Domain\Criteria;

use Codigito\Shared\Domain\Filter\Criteria;
use Codigito\Shared\Domain\Filter\FilterField;
use Codigito\Shared\Domain\Filter\Filters;
use Codigito\Shared\Domain\Filter\Order;
use Codigito\Shared\Domain\Filter\Page;

class TagSearchByFieldCriteria extends Criteria
{
    public function __construct(
        public readonly string $field,
        public readonly string|int|bool|null $value,
        int $page = Page::FIRST_PAGE,
        int $limit = Page::PAGE_LIMIT
    ) {
        $filters = [$this->equal($field, $value)];

        parent::__construct(
            new Filters($filters),
            Order::asc(new FilterField('name')),
            Page::from($page, $limit)
        );
    }
}
