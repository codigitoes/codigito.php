<?php

declare(strict_types=1);

namespace Codigito\Shared\Domain\Service;

use Codigito\Shared\Domain\ValueObject\UuidV4Id;

interface ResourceIdExistsService
{
    public function exists(UuidV4Id $id): bool;

    public function notExists(UuidV4Id $id): bool;
}
