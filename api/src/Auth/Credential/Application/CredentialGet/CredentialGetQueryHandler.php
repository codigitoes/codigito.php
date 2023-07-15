<?php

declare(strict_types=1);

namespace Codigito\Auth\Credential\Application\CredentialGet;

use Codigito\Auth\Credential\Domain\Criteria\CredentialSearchByIdCriteria;
use Codigito\Auth\Credential\Domain\Model\CredentialGetReadModel;
use Codigito\Auth\Credential\Domain\Repository\CredentialReader;
use Codigito\Shared\Domain\Query\Query;
use Codigito\Shared\Domain\Query\QueryHandler;

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
