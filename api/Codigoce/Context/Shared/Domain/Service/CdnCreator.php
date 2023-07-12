<?php

declare(strict_types=1);

namespace Codigoce\Context\Shared\Domain\Service;

interface CdnCreator
{
    public function create(string $source): string;

    public function delete(string $filename): void;
}
