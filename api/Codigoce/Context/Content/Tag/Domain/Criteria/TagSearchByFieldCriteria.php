<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Tag\Domain\Criteria;

use Codigoce\Context\Shared\Domain\Filter\Criteria;
use Codigoce\Context\Shared\Domain\Filter\FilterField;
use Codigoce\Context\Shared\Domain\Filter\Filters;
use Codigoce\Context\Shared\Domain\Filter\Order;
use Codigoce\Context\Shared\Domain\Filter\Page;

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
