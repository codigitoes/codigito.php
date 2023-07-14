<?php

declare(strict_types=1);

namespace Core\Context\Shared\Domain\Service;

use Core\Context\Shared\Domain\ValueObject\Title;

interface ResourceTitleExistsService
{
    public function exists(Title $title): bool;

    public function notExists(Title $title): bool;
}
