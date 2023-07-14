<?php

declare(strict_types=1);

namespace Core\\Fidelization\Mailing\Domain\Criteria;

use Core\\Shared\Domain\Filter\Page;
use Core\\Shared\Domain\Filter\Order;
use Core\\Shared\Domain\Filter\Filter;
use Core\\Shared\Domain\Filter\Filters;
use Core\\Shared\Domain\Filter\Criteria;
use Core\\Shared\Domain\Filter\FilterField;
use Core\\Shared\Domain\Filter\FilterValue;
use Core\\Shared\Domain\Filter\FilterTypeLike;

class MailingSearchCriteria extends Criteria
{
    public function __construct(
        public readonly ?string $pattern = '',
        int $page = Page::FIRST_PAGE,
        int $limit = Page::PAGE_LIMIT
    ) {
        $filters = [];
        if ($pattern) {
            $filters[] = new Filter(
                new FilterField('email'),
                new FilterTypeLike(),
                new FilterValue($pattern)
            );
        }

        parent::__construct(
            new Filters($filters),
            Order::desc(new FilterField('created')),
            Page::from($page, $limit)
        );
    }
}
