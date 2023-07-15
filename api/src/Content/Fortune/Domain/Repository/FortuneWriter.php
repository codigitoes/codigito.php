<?php

declare(strict_types=1);

namespace Codigito\Content\Fortune\Domain\Repository;

use Codigito\Content\Fortune\Domain\Model\Fortune;
use Codigito\Content\Fortune\Domain\ValueObject\FortuneId;

interface FortuneWriter
{
    public function create(Fortune $fortune): void;

    public function delete(FortuneId $id): void;
}
