<?php

declare(strict_types=1);

namespace Core\Context\Shared\Domain\Service;

interface CdnCreator
{
    public function create(string $source): string;

    public function delete(string $filename): void;
}
