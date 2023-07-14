<?php

declare(strict_types=1);

namespace Core\Context\Content\Blogpost\Domain\Criteria;

use Core\Context\Shared\Domain\Filter\Page;
use Core\Context\Shared\Domain\Filter\Order;
use Core\Context\Shared\Domain\Filter\Filter;
use Core\Context\Shared\Domain\Filter\Filters;
use Core\Context\Shared\Domain\Filter\Criteria;
use Core\Context\Shared\Domain\Filter\FilterField;
use Core\Context\Shared\Domain\Filter\FilterValue;
use Core\Context\Shared\Domain\Filter\FilterTypeLikesOr;

class BlogpostSearchCriteria extends Criteria
{
    public function __construct(
        public readonly ?string $pattern = '',
        int $page = Page::FIRST_PAGE,
        int $limit = Page::PAGE_LIMIT
    ) {
        $filters = [];
        if ($pattern) {
            $filters[] = new Filter(
                new FilterField(['name', 'tags']),
                new FilterTypeLikesOr(),
                new FilterValue([$pattern])
            );
        }

        parent::__construct(
            new Filters($filters),
            Order::desc(new FilterField('created')),
            Page::from($page, $limit)
        );
    }
}
