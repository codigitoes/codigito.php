<?php

declare(strict_types=1);

namespace Core\Context\Content\Tag\Domain\Criteria;

use Core\Context\Shared\Domain\Filter\Criteria;
use Core\Context\Shared\Domain\Filter\FilterField;
use Core\Context\Shared\Domain\Filter\Filters;
use Core\Context\Shared\Domain\Filter\Order;
use Core\Context\Shared\Domain\Filter\Page;

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
