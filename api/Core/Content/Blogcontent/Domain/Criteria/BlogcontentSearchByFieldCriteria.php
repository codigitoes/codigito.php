<?php

declare(strict_types=1);

namespace Core\\Content\Blogcontent\Domain\Criteria;

use Core\\Shared\Domain\Filter\Criteria;
use Core\\Shared\Domain\Filter\Filter;
use Core\\Shared\Domain\Filter\FilterField;
use Core\\Shared\Domain\Filter\Filters;
use Core\\Shared\Domain\Filter\FilterTypeEqual;
use Core\\Shared\Domain\Filter\FilterValue;
use Core\\Shared\Domain\Filter\Order;
use Core\\Shared\Domain\Filter\Page;

class BlogcontentSearchByFieldCriteria extends Criteria
{
    public function __construct(
        public readonly string $blogpostId,
        public readonly string $field,
        public readonly string|int|bool|null $value,
        int $page = Page::FIRST_PAGE,
        int $limit = Page::PAGE_LIMIT
    ) {
        $filters = [
            $this->equal('blogpostId', $blogpostId),
            new Filter(
                new FilterField($this->field),
                new FilterTypeEqual(),
                new FilterValue($this->value)
            )
        ];

        parent::__construct(
            new Filters($filters),
            Order::asc(new FilterField('position')),
            Page::from($page, $limit)
        );
    }
}
