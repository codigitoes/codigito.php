<?php

declare(strict_types=1);

namespace Codigito\Shared\Domain\Service;

interface ValidatorBoundaryFacadeService
{
    public function validate(array $params): void;
}
