<?php

declare(strict_types=1);

namespace Core\Content\Tag\Domain\Criteria;

use Core\Shared\Domain\Filter\Criteria;
use Core\Shared\Domain\Filter\FilterField;
use Core\Shared\Domain\Filter\Filters;
use Core\Shared\Domain\Filter\Order;
use Core\Shared\Domain\Filter\Page;

class TagSearchByNameCriteria extends Criteria
{
    public function __construct(
        public readonly string $name
    ) {
        $filters = [$this->equalName($name)];

        parent::__construct(
            new Filters($filters),
            Order::asc(new FilterField('name')),
            Page::first25()
        );
    }
}
