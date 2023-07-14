<?php

declare(strict_types=1);

namespace Core\Content\Fortune\Domain\Repository;

use Core\Shared\Domain\Filter\Criteria;
use Core\Content\Fortune\Domain\Model\Fortune;
use Core\Content\Fortune\Domain\Model\FortuneGetReadModel;
use Core\Content\Fortune\Domain\Model\FortuneCollectionReadModel;

interface FortuneReader
{
    public function rand(): FortuneGetReadModel;

    public function getFortuneModelByCriteria(Criteria $criteria): Fortune;

    public function all(): FortuneCollectionReadModel;
}
