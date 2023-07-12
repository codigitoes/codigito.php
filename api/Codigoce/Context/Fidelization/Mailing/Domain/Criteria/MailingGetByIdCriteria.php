<?php

declare(strict_types=1);

namespace Codigoce\Context\Fidelization\Mailing\Domain\Criteria;

use Codigoce\Context\Shared\Domain\Filter\Page;
use Codigoce\Context\Shared\Domain\Filter\Order;
use Codigoce\Context\Shared\Domain\Filter\Filters;
use Codigoce\Context\Shared\Domain\Filter\Criteria;
use Codigoce\Context\Shared\Domain\Filter\FilterField;

class MailingGetByIdCriteria extends Criteria
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
