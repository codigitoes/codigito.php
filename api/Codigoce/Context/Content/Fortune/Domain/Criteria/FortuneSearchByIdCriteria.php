<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Fortune\Domain\Criteria;

use Codigoce\Context\Shared\Domain\Filter\Page;
use Codigoce\Context\Shared\Domain\Filter\Order;
use Codigoce\Context\Shared\Domain\Filter\Filter;
use Codigoce\Context\Shared\Domain\Filter\Filters;
use Codigoce\Context\Shared\Domain\Filter\Criteria;
use Codigoce\Context\Shared\Domain\Filter\FilterField;
use Codigoce\Context\Shared\Domain\Filter\FilterValue;
use Codigoce\Context\Shared\Domain\Filter\FilterTypeEqual;

class FortuneSearchByIdCriteria extends Criteria
{
    public function __construct(
        public readonly string $id,
        ?string $fieldName = null
    ) {
        $idKey = 'id';
        if ($fieldName) {
            $idKey = $fieldName;
        }

        $filters = [new Filter(
            new FilterField($idKey),
            new FilterTypeEqual(),
            new FilterValue($id)
        )];

        parent::__construct(
            new Filters($filters),
            Order::desc(new FilterField('created')),
            Page::first25()
        );
    }
}