<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Fortune\Domain\Repository;

use Codigoce\Context\Content\Fortune\Domain\Model\Fortune;
use Codigoce\Context\Content\Fortune\Domain\ValueObject\FortuneId;

interface FortuneWriter
{
    public function create(Fortune $fortune): void;

    public function delete(FortuneId $id): void;
}
