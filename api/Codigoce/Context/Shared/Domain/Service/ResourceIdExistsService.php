<?php

declare(strict_types=1);

namespace Codigoce\Context\Shared\Domain\Service;

use Codigoce\Context\Shared\Domain\ValueObject\UuidV4Id;

interface ResourceIdExistsService
{
    public function exists(UuidV4Id $id): bool;

    public function notExists(UuidV4Id $id): bool;
}
