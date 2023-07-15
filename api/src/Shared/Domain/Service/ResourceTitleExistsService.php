<?php

declare(strict_types=1);

namespace Codigito\Shared\Domain\Service;

use Codigito\Shared\Domain\ValueObject\Title;

interface ResourceTitleExistsService
{
    public function exists(Title $title): bool;

    public function notExists(Title $title): bool;
}
