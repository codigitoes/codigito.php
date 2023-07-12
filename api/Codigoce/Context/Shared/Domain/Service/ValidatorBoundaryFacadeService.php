<?php

declare(strict_types=1);

namespace Codigoce\Context\Shared\Domain\Service;

interface ValidatorBoundaryFacadeService
{
    public function validate(array $params): void;
}
