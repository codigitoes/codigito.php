<?php

declare(strict_types=1);

namespace Codigoce\Context\Fidelization\Mailing\Domain\Criteria;

use Codigoce\Context\Shared\Domain\Filter\Page;
use Codigoce\Context\Shared\Domain\Filter\Order;
use Codigoce\Context\Shared\Domain\Filter\Filter;
use Codigoce\Context\Shared\Domain\Filter\Filters;
use Codigoce\Context\Shared\Domain\Filter\Criteria;
use Codigoce\Context\Shared\Domain\Filter\FilterField;
use Codigoce\Context\Shared\Domain\Filter\FilterValue;
use Codigoce\Context\Shared\Domain\Filter\FilterTypeLike;

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
