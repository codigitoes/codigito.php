<?php

declare(strict_types=1);

namespace Codigito\Fidelization\Mailing\Domain\Criteria;

use Codigito\Shared\Domain\Filter\Page;
use Codigito\Shared\Domain\Filter\Order;
use Codigito\Shared\Domain\Filter\Filter;
use Codigito\Shared\Domain\Filter\Filters;
use Codigito\Shared\Domain\Filter\Criteria;
use Codigito\Shared\Domain\Filter\FilterField;
use Codigito\Shared\Domain\Filter\FilterValue;
use Codigito\Shared\Domain\Filter\FilterTypeEqual;

class MailingSearchByIdCriteria extends Criteria
{
    public function __construct(
        public readonly string $id,
        string $fieldEmail = null
    ) {
        $idKey = 'id';
        if ($fieldEmail) {
            $idKey = $fieldEmail;
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
