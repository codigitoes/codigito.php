<?php

declare(strict_types=1);

namespace Core\Context\Content\Tag\Domain\Criteria;

use Core\Context\Shared\Domain\Filter\Criteria;
use Core\Context\Shared\Domain\Filter\FilterField;
use Core\Context\Shared\Domain\Filter\Filters;
use Core\Context\Shared\Domain\Filter\Order;
use Core\Context\Shared\Domain\Filter\Page;

class TagGetByIdCriteria extends Criteria
{
    public function __construct(
        public readonly string $id
    ) {
        $filters = [$this->equalId($id)];

        parent::__construct(
            new Filters($filters),
            Order::asc(new FilterField('name')),
            Page::one()
        );
    }
}
