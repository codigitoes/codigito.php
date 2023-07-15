<?php

declare(strict_types=1);

namespace Codigito\Content\Tag\Domain\Criteria;

use Codigito\Shared\Domain\Filter\Criteria;
use Codigito\Shared\Domain\Filter\FilterField;
use Codigito\Shared\Domain\Filter\Filters;
use Codigito\Shared\Domain\Filter\Order;
use Codigito\Shared\Domain\Filter\Page;

class TagSearchByIdCriteria extends Criteria
{
    public function __construct(
        public readonly string $id,
        ?string $fieldName = null
    ) {
        $idKey = 'id';
        if ($fieldName) {
            $idKey = $fieldName;
        }

        $filters = [$this->equal($idKey, $id)];

        parent::__construct(
            new Filters($filters),
            Order::asc(new FilterField('name')),
            Page::first25()
        );
    }
}
