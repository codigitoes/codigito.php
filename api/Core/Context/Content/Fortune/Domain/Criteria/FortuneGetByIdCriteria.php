<?php

declare(strict_types=1);

namespace Core\Context\Content\Fortune\Domain\Criteria;

use Core\Context\Shared\Domain\Filter\Page;
use Core\Context\Shared\Domain\Filter\Order;
use Core\Context\Shared\Domain\Filter\Filters;
use Core\Context\Shared\Domain\Filter\Criteria;
use Core\Context\Shared\Domain\Filter\FilterField;

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
