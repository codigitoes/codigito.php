<?php

declare(strict_types=1);

namespace Codigoce\Context\Auth\Credential\Domain\Repository;

use Codigoce\Context\Auth\Credential\Domain\Model\Credential;
use Codigoce\Context\Auth\Credential\Domain\ValueObject\CredentialId;

interface CredentialWriter
{
    public function create(Credential $credential): void;

    public function delete(CredentialId $id): void;

    public function update(Credential $credential): void;
}
