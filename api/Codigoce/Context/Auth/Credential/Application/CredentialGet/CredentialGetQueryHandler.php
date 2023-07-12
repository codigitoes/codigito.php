<?php

declare(strict_types=1);

namespace Codigoce\Context\Auth\Credential\Application\CredentialGet;

use Codigoce\Context\Auth\Credential\Domain\Criteria\CredentialSearchByIdCriteria;
use Codigoce\Context\Auth\Credential\Domain\Model\CredentialGetReadModel;
use Codigoce\Context\Auth\Credential\Domain\Repository\CredentialReader;
use Codigoce\Context\Shared\Domain\Query\Query;
use Codigoce\Context\Shared\Domain\Query\QueryHandler;

class CredentialGetQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly CredentialReader $reader
    ) {
    }

    public function execute(Query $query): CredentialGetReadModel
    {
        $criteria = new CredentialSearchByIdCriteria($query->id);

        return $this->reader->getCredentialByCriteria($criteria);
    }
}
