<?php

declare(strict_types=1);

namespace Core\\Content\Fortune\Domain\Criteria;

use Core\\Shared\Domain\Filter\Page;
use Core\\Shared\Domain\Filter\Order;
use Core\\Shared\Domain\Filter\Filters;
use Core\\Shared\Domain\Filter\Criteria;
use Core\\Shared\Domain\Filter\FilterField;

class FortuneGetByIdCriteria extends Criteria
{
    public function __construct(
        public readonly string $id
    ) {
        $filters = [$this->equalId($id)];

        parent::__construct(
            new Filters($filters),
            Order::desc(new FilterField('created')),
            Page::one()
        );
    }
}
