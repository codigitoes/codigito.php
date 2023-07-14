<?php

declare(strict_types=1);

namespace Core\Content\Tag\Domain\Criteria;

use Core\Shared\Domain\Filter\Criteria;
use Core\Shared\Domain\Filter\Filter;
use Core\Shared\Domain\Filter\FilterField;
use Core\Shared\Domain\Filter\Filters;
use Core\Shared\Domain\Filter\FilterTypeLike;
use Core\Shared\Domain\Filter\FilterValue;
use Core\Shared\Domain\Filter\Order;
use Core\Shared\Domain\Filter\Page;

class TagSearchCriteria extends Criteria
{
    public function __construct(
        public readonly ?string $pattern = '',
        int $page = Page::FIRST_PAGE,
        int $limit = Page::PAGE_LIMIT
    ) {
        $filters = [];
        if ($pattern) {
            $filters[] = new Filter(
                new FilterField('name'),
                new FilterTypeLike(),
                new FilterValue($pattern)
            );
        }

        parent::__construct(
            new Filters($filters),
            Order::asc(new FilterField('name')),
            Page::from($page, $limit)
        );
    }
}
