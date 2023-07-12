<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Tag\Domain\Criteria;

use Codigoce\Context\Shared\Domain\Filter\Criteria;
use Codigoce\Context\Shared\Domain\Filter\FilterField;
use Codigoce\Context\Shared\Domain\Filter\Filters;
use Codigoce\Context\Shared\Domain\Filter\Order;
use Codigoce\Context\Shared\Domain\Filter\Page;

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
