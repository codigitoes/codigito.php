<?php

declare(strict_types=1);

namespace Core\Shared\Domain\Service;

use Core\Shared\Domain\ValueObject\UuidV4Id;

interface ResourceIdExistsService
{
    public function exists(UuidV4Id $id): bool;

    public function notExists(UuidV4Id $id): bool;
}
