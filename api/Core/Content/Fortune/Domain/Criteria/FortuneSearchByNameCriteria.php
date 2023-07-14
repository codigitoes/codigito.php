<?php

declare(strict_types=1);

namespace Core\Content\Fortune\Domain\Criteria;

use Core\Shared\Domain\Filter\Page;
use Core\Shared\Domain\Filter\Order;
use Core\Shared\Domain\Filter\Filter;
use Core\Shared\Domain\Filter\Filters;
use Core\Shared\Domain\Filter\Criteria;
use Core\Shared\Domain\Filter\FilterField;
use Core\Shared\Domain\Filter\FilterValue;
use Core\Shared\Domain\Filter\FilterTypeEqual;

class FortuneSearchByNameCriteria extends Criteria
{
    public function __construct(
        public readonly string $name
    ) {
        $filters = [new Filter(
            new FilterField('name'),
            new FilterTypeEqual(),
            new FilterValue($name)
        )];

        parent::__construct(
            new Filters($filters),
            Order::desc(new FilterField('created')),
            Page::first25()
        );
    }
}
