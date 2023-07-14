<?php

declare(strict_types=1);

namespace Core\Context\Content\Tag\Domain\Criteria;

use Core\Context\Shared\Domain\Filter\Page;
use Core\Context\Shared\Domain\Filter\Order;
use Core\Context\Shared\Domain\Filter\Filters;
use Core\Context\Shared\Domain\Filter\Criteria;
use Core\Context\Shared\Domain\Filter\FilterField;

class TagGetByNameCriteria extends Criteria
{
    public function __construct(
        public readonly string $name
    ) {
        $filters = [$this->equalName($name)];

        parent::__construct(
            new Filters($filters),
            Order::asc(new FilterField('name')),
            Page::one()
        );
    }
}
