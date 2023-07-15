<?php

declare(strict_types=1);

namespace Codigito\Content\Fortune\Domain\Criteria;

use Codigito\Shared\Domain\Filter\Page;
use Codigito\Shared\Domain\Filter\Order;
use Codigito\Shared\Domain\Filter\Filters;
use Codigito\Shared\Domain\Filter\Criteria;
use Codigito\Shared\Domain\Filter\FilterField;

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
