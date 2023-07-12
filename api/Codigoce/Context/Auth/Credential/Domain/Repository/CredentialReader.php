<?php

declare(strict_types=1);

namespace Codigoce\Context\Auth\Credential\Domain\Repository;

use Codigoce\Context\Auth\Credential\Domain\Model\Credential;
use Codigoce\Context\Auth\Credential\Domain\Model\CredentialGetReadModel;
use Codigoce\Context\Shared\Domain\Filter\Criteria;

interface CredentialReader
{
    public function getCredentialByCriteria(Criteria $criteria): CredentialGetReadModel;

    public function getCredentialModelByCriteria(Criteria $criteria): Credential;
}
