<?php

declare(strict_types=1);

namespace Codigoce\Context\Shared\Domain\Service;

use Codigoce\Context\Shared\Domain\ValueObject\Title;

interface ResourceTitleExistsService
{
    public function exists(Title $title): bool;

    public function notExists(Title $title): bool;
}
