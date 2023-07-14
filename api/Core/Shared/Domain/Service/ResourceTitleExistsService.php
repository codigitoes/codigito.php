<?php

declare(strict_types=1);

namespace Core\Shared\Domain\Service;

use Core\Shared\Domain\ValueObject\Title;

interface ResourceTitleExistsService
{
    public function exists(Title $title): bool;

    public function notExists(Title $title): bool;
}
