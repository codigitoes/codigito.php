<?php

declare(strict_types=1);

namespace Core\Context\Fidelization\Mailing\Domain\Criteria;

use Core\Context\Shared\Domain\Filter\Criteria;
use Core\Context\Shared\Domain\Filter\Filter;
use Core\Context\Shared\Domain\Filter\FilterField;
use Core\Context\Shared\Domain\Filter\Filters;
use Core\Context\Shared\Domain\Filter\FilterTypeEqual;
use Core\Context\Shared\Domain\Filter\FilterValue;
use Core\Context\Shared\Domain\Filter\Order;
use Core\Context\Shared\Domain\Filter\Page;

class MailingSearchByFieldCriteria extends Criteria
{
    public function __construct(
        public readonly string $field,
        public readonly string|int|bool|null $value,
        int $page = Page::FIRST_PAGE,
        int $limit = Page::PAGE_LIMIT
    ) {
        $filters = [new Filter(
            new FilterField($this->field),
            new FilterTypeEqual(),
            new FilterValue($this->value)
        )];

        parent::__construct(
            new Filters($filters),
            Order::desc(new FilterField('created')),
            Page::from($page, $limit)
        );
    }
}
