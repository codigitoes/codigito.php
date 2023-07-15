<?php

declare(strict_types=1);

namespace Codigito\Auth\Credential\Domain\Repository;

use Codigito\Auth\Credential\Domain\Model\Credential;
use Codigito\Auth\Credential\Domain\Model\CredentialGetReadModel;
use Codigito\Shared\Domain\Filter\Criteria;

interface CredentialReader
{
    public function getCredentialByCriteria(Criteria $criteria): CredentialGetReadModel;

    public function getCredentialModelByCriteria(Criteria $criteria): Credential;
}
