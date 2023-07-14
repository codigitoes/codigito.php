<?php

declare(strict_types=1);

namespace Core\Content\Fortune\Domain\Repository;

use Core\Content\Fortune\Domain\Model\Fortune;
use Core\Content\Fortune\Domain\ValueObject\FortuneId;

interface FortuneWriter
{
    public function create(Fortune $fortune): void;

    public function delete(FortuneId $id): void;
}
