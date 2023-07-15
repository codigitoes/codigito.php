<?php

declare(strict_types=1);

namespace Codigito\Auth\Credential\Domain\Repository;

use Codigito\Auth\Credential\Domain\Model\Credential;
use Codigito\Auth\Credential\Domain\ValueObject\CredentialId;

interface CredentialWriter
{
    public function create(Credential $credential): void;

    public function delete(CredentialId $id): void;

    public function update(Credential $credential): void;
}
