<?php

declare(strict_types=1);

namespace Codigoce\Context\Auth\Credential\Domain\Criteria;

use Codigoce\Context\Shared\Domain\Filter\Criteria;
use Codigoce\Context\Shared\Domain\Filter\FilterField;
use Codigoce\Context\Shared\Domain\Filter\Filters;
use Codigoce\Context\Shared\Domain\Filter\Order;
use Codigoce\Context\Shared\Domain\Filter\Page;

class CredentialSearchByEmailCriteria extends Criteria
{
    public function __construct(
        public readonly string $email
    ) {
        $filters = [$this->equal('email', $email)];

        parent::__construct(
            new Filters($filters),
            Order::desc(new FilterField('created')),
            Page::first25()
        );
    }
}
