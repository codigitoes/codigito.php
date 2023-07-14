<?php

declare(strict_types=1);

namespace Core\Content\Tag\Domain\Criteria;

use Core\Shared\Domain\Filter\Criteria;
use Core\Shared\Domain\Filter\FilterField;
use Core\Shared\Domain\Filter\Filters;
use Core\Shared\Domain\Filter\Order;
use Core\Shared\Domain\Filter\Page;

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
